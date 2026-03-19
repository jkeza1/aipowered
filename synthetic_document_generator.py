import os
import random
import json
import cv2
import numpy as np
from PIL import Image, ImageDraw, ImageFont
from pathlib import Path

class RwandanDocumentGenerator:
    def __init__(self, output_dir='synthetic_documents', font_path=None, sync_to_training_dirs=True):
        self.output_dir = Path(output_dir)
        self.project_root = Path(__file__).resolve().parent
        self.assets_dir = self.project_root / 'assets'
        self.stamp_path = self.assets_dir / 'stamp.png'
        self.fixed_output_dir = self.project_root / 'fixed_synthetic'
        self.high_risk_output_dir = self.project_root / 'high_risk_dataset'
        self.sync_to_training_dirs = sync_to_training_dirs
        # Use a standard font or fall back to default
        self.font_path = font_path or "C:/Windows/Fonts/arial.ttf"
        
        # High-Risk Document Categories (Rwandan 2025/2026 Ecosystem)
        self.doc_types = [
            'salary_slip', 'bank_statement', 'employment_contract',
            'court_judgment', 'certificate_of_celibacy', 'criminal_record_clearance',
            'academic_transcript', 'notarial_act', 'power_of_attorney'
        ]
        
        # Ensure directories exist
        for dt in self.doc_types:
            (self.output_dir / dt / 'valid').mkdir(parents=True, exist_ok=True)
            (self.output_dir / dt / 'invalid').mkdir(parents=True, exist_ok=True)
            (self.fixed_output_dir / dt / 'valid').mkdir(parents=True, exist_ok=True)
            (self.fixed_output_dir / dt / 'invalid').mkdir(parents=True, exist_ok=True)
            (self.high_risk_output_dir / dt / 'valid').mkdir(parents=True, exist_ok=True)
            (self.high_risk_output_dir / dt / 'invalid').mkdir(parents=True, exist_ok=True)

        self.stamp_image = self._load_stamp_image()

    def _load_stamp_image(self):
        """Load transparent stamp asset if available; return None if missing."""
        if self.stamp_path.exists():
            try:
                return Image.open(self.stamp_path).convert('RGBA')
            except Exception:
                return None
        return None

    def _create_textured_background(self, width=224, height=224):
        """Create a subtle off-white textured paper background."""
        base = np.full((height, width, 3), 244, dtype=np.uint8)
        noise = np.random.normal(loc=0.0, scale=5.5, size=(height, width, 3))
        textured = np.clip(base.astype(np.float32) + noise, 224, 252).astype(np.uint8)
        return Image.fromarray(textured, mode='RGB')

    def _draw_text_with_jitter(self, draw, x, y, text, font, fill=(0, 0, 0), spacing_jitter=1):
        """Write text with slight per-character spacing jitter to mimic printer variance."""
        cx = x
        for ch in text:
            draw.text((cx, y), ch, fill=fill, font=font)
            bbox = draw.textbbox((cx, y), ch, font=font)
            ch_w = max(1, bbox[2] - bbox[0])
            cx += ch_w + random.randint(-spacing_jitter, spacing_jitter)

    def _apply_stamp_overlay(self, img):
        """Overlay a semi-transparent government stamp with random placement/rotation."""
        canvas = img.convert('RGBA')

        if self.stamp_image is not None:
            stamp = self.stamp_image.copy()
        else:
            # Fallback synthetic stamp if assets/stamp.png is unavailable.
            stamp = Image.new('RGBA', (96, 96), (0, 0, 0, 0))
            sdraw = ImageDraw.Draw(stamp)
            sdraw.ellipse((4, 4, 92, 92), outline=(150, 20, 20, 220), width=4)
            sdraw.text((18, 40), 'RW', fill=(150, 20, 20, 220))

        target_size = random.randint(70, 110)
        stamp = stamp.resize((target_size, target_size), Image.Resampling.LANCZOS)
        stamp = stamp.rotate(random.uniform(-18, 18), expand=True, resample=Image.Resampling.BICUBIC)

        alpha = stamp.split()[-1]
        alpha_scale = random.uniform(0.22, 0.4)
        alpha = alpha.point(lambda px: int(px * alpha_scale))
        stamp.putalpha(alpha)

        max_x = max(1, canvas.width - stamp.width)
        max_y = max(1, canvas.height - stamp.height)
        x = random.randint(0, max_x)
        y = random.randint(0, max_y)
        canvas.alpha_composite(stamp, (x, y))

        return canvas.convert('RGB')

    def _apply_forgery_splice(self, img, y_offset, forged_text):
        """Splice a subtly mismatched text strip to simulate forensic-level manipulation."""
        arr = np.array(img)
        h, w = arr.shape[:2]

        patch_h = 18
        patch_w = random.randint(120, 170)
        x1 = random.randint(12, max(12, w - patch_w - 12))
        y1 = max(8, min(h - patch_h - 8, y_offset - 3))
        patch = arr[y1:y1 + patch_h, x1:x1 + patch_w].copy()

        patch = cv2.GaussianBlur(patch, (3, 3), sigmaX=0.7)
        patch = np.clip(patch.astype(np.int16) + random.randint(-10, 10), 0, 255).astype(np.uint8)

        patch_img = Image.fromarray(patch)
        pdraw = ImageDraw.Draw(patch_img)
        try:
            splice_font = ImageFont.truetype(self.font_path, 9)
        except Exception:
            splice_font = ImageFont.load_default()
        pdraw.text((4, 3), forged_text, fill=(20, 20, 20), font=splice_font)

        patch_arr = np.array(patch_img)
        alpha = random.uniform(0.7, 0.9)
        arr[y1:y1 + patch_h, x1:x1 + patch_w] = (
            alpha * patch_arr + (1.0 - alpha) * arr[y1:y1 + patch_h, x1:x1 + patch_w]
        ).astype(np.uint8)

        return Image.fromarray(arr)

    def _apply_scan_distortion(self, img, profile='medium'):
        """Apply blur, sensor noise, tiny rotation, and JPEG artifacts to mimic scanning."""
        arr = np.array(img)
        h, w = arr.shape[:2]

        if profile == 'high':
            angle_range = 1.8
            blur_sigma = (0.7, 1.4)
            noise_sigma = (4.0, 8.0)
            jpeg_quality = (72, 88)
        else:
            angle_range = 1.2
            blur_sigma = (0.3, 0.9)
            noise_sigma = (2.0, 5.0)
            jpeg_quality = (82, 94)

        # Tiny geometric jitter around 1% angle.
        angle = random.uniform(-angle_range, angle_range)
        matrix = cv2.getRotationMatrix2D((w / 2.0, h / 2.0), angle, 1.0)
        arr = cv2.warpAffine(arr, matrix, (w, h), flags=cv2.INTER_LINEAR, borderMode=cv2.BORDER_REPLICATE)

        # Optics blur + sensor noise.
        arr = cv2.GaussianBlur(arr, (3, 3), sigmaX=random.uniform(*blur_sigma))
        noise = np.random.normal(0, random.uniform(*noise_sigma), arr.shape).astype(np.float32)
        arr = np.clip(arr.astype(np.float32) + noise, 0, 255).astype(np.uint8)

        # Compression artifacts simulation.
        ok, enc = cv2.imencode('.jpg', cv2.cvtColor(arr, cv2.COLOR_RGB2BGR), [int(cv2.IMWRITE_JPEG_QUALITY), random.randint(*jpeg_quality)])
        if ok:
            arr = cv2.cvtColor(cv2.imdecode(enc, cv2.IMREAD_COLOR), cv2.COLOR_BGR2RGB)

        return Image.fromarray(arr)

    def _generate_base_image(self, doc_type, name, national_id, is_valid=True, distortion_profile='medium'):
        # Create textured paper-like background (standardized for EfficientNet input).
        img = self._create_textured_background(224, 224)
        draw = ImageDraw.Draw(img)
        
        try:
            font_small = ImageFont.truetype(self.font_path, 8)
            font_bold = ImageFont.truetype(self.font_path, 10)
        except:
            font_small = ImageFont.load_default()
            font_bold = ImageFont.load_default()

        # Header: Common Irembo/Gov Header
        self._draw_text_with_jitter(draw, 10, 5, "REPUBLIC OF RWANDA / IREMBO GOV", font_small)
        
        # Mapping Doc Types to Content
        y_offset = 25
        title = doc_type.replace('_', ' ').upper()
        self._draw_text_with_jitter(draw, 10, y_offset, title, font_bold, fill=(0, 0, 100))
        
        y_offset += 25
        self._draw_text_with_jitter(draw, 10, y_offset, f"Holder: {name}", font_small)
        y_offset += 15
        self._draw_text_with_jitter(draw, 10, y_offset, f"NID: {national_id}", font_small)

        # Category Specific Logic
        y_offset += 25
        forgery_applied = False
        if doc_type in ['salary_slip', 'bank_statement']:
            amount = random.randint(300000, 2500000)
            self._draw_text_with_jitter(draw, 10, y_offset, f"Net Amount: {amount:,} RWF", font_small)
            if not is_valid:
                img = self._apply_forgery_splice(img, y_offset, f"{amount*2:,} RWF")
            forgery_applied = True
        
        elif doc_type == 'certificate_of_celibacy':
            self._draw_text_with_jitter(draw, 10, y_offset, "Status: SINGLE / CELIBATAIRE", font_small)
            if not is_valid:
                img = self._apply_forgery_splice(img, y_offset, "Status: MARRIED / CELIBATAIRE")
                forgery_applied = True

        elif doc_type in ['academic_transcript', 'notarial_act']:
            verify_code = "Verification Code: RW-" + str(random.randint(1000, 9999))
            self._draw_text_with_jitter(draw, 10, y_offset, verify_code, font_small)
            if not is_valid:
                img = self._apply_forgery_splice(img, y_offset, "Verification Code: RW-0000")
                forgery_applied = True

        # Default forensic tamper for any unsupported category.
        if not is_valid and not forgery_applied:
            img = self._apply_forgery_splice(img, y_offset, "AUTHORIZED COPY")

        # Add stamp to both classes to avoid shortcut learning.
        img = self._apply_stamp_overlay(img)

        # Final scan distortion on both classes for realistic capture conditions.
        img = self._apply_scan_distortion(img, profile=distortion_profile)

        return img

    def _save_to_target_folder(self, img, target_root, doc_type, status, filename):
        path = target_root / doc_type / status / filename
        img.save(path)

    def _route_target_root(self, noise_profile):
        # High-distortion samples are routed to high-risk; others to fixed.
        return self.high_risk_output_dir if str(noise_profile).lower() == 'high' else self.fixed_output_dir

    def generate_from_registry(self, records, samples_per_record=5):
        """Generates documents using real identities from MySQL."""
        print(f"🚀 Starting dataset generation from {len(records)} identities...")
        
        for record in records:
            name = f"{record['first_name']} {record['last_name']}"
            nid = record['national_id']
            
            for _ in range(samples_per_record):
                doc_type = random.choice(self.doc_types)
                noise_profile = random.choice(['medium', 'high'])
                
                # Generate Valid
                valid_name = f"valid_{nid}_{random.randint(1000,9999)}.jpg"
                img_valid = self._generate_base_image(doc_type, name, nid, is_valid=True, distortion_profile=noise_profile)
                valid_path = self.output_dir / doc_type / 'valid' / valid_name
                img_valid.save(valid_path)
                if self.sync_to_training_dirs:
                    self._save_to_target_folder(img_valid, self._route_target_root(noise_profile), doc_type, 'valid', valid_name)
                
                # Generate Invalid (Tampered version of same ID)
                invalid_name = f"tamp_{nid}_{random.randint(1000,9999)}.jpg"
                img_invalid = self._generate_base_image(doc_type, name, nid, is_valid=False, distortion_profile=noise_profile)
                invalid_path = self.output_dir / doc_type / 'invalid' / invalid_name
                img_invalid.save(invalid_path)
                if self.sync_to_training_dirs:
                    self._save_to_target_folder(img_invalid, self._route_target_root(noise_profile), doc_type, 'invalid', invalid_name)

        print(f"✅ Generation complete. Samples saved to {self.output_dir}")
        if self.sync_to_training_dirs:
            print(f"✅ Also mirrored to: {self.fixed_output_dir} and {self.high_risk_output_dir}")

    def generate_dataset(self, num_samples_per_type=1500, noise_levels=['medium']):
        """Fallback method for generic generation if registry is empty."""
        names = ["Umuhoza Alice", "Kamanzi Jean", "Murenzi Eric", "Irakoze Gad"]
        allowed_levels = [str(n).lower() for n in noise_levels] if noise_levels else ['medium']

        for dt in self.doc_types:
            for i in range(num_samples_per_type):
                name = random.choice(names)
                nid = f"11990{random.randint(10000000000, 99999999999)}"
                noise_profile = random.choice(allowed_levels)
                
                status = 'valid' if i % 2 == 0 else 'invalid'
                filename = f"gen_{i}_{noise_profile}.jpg"
                img = self._generate_base_image(dt, name, nid, is_valid=(status == 'valid'), distortion_profile=noise_profile)
                path = self.output_dir / dt / status / filename
                img.save(path)
                if self.sync_to_training_dirs:
                    self._save_to_target_folder(img, self._route_target_root(noise_profile), dt, status, filename)

        print(f"✅ Generic dataset generation complete in: {self.output_dir}")
        if self.sync_to_training_dirs:
            print(f"✅ Mirrored samples into fixed/high-risk training folders.")
