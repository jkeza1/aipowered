import os
import random
import json
import cv2
import numpy as np
from PIL import Image, ImageDraw, ImageFont
from pathlib import Path

class RwandanDocumentGenerator:
    def __init__(self, output_dir='synthetic_documents', font_path=None):
        self.output_dir = Path(output_dir)
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

    def _generate_base_image(self, doc_type, name, national_id, is_valid=True):
        # Create a $224 \times 224$ blank document (standardized for EfficientNet)
        img = Image.new('RGB', (224, 224), color=(245, 245, 245))
        draw = ImageDraw.Draw(img)
        
        try:
            font_small = ImageFont.truetype(self.font_path, 8)
            font_bold = ImageFont.truetype(self.font_path, 10)
        except:
            font_small = ImageFont.load_default()
            font_bold = ImageFont.load_default()

        # Header: Common Irembo/Gov Header
        draw.text((10, 5), "REPUBLIC OF RWANDA / IREMBO GOV", fill=(0, 0, 0), font=font_small)
        
        # Mapping Doc Types to Content
        y_offset = 25
        title = doc_type.replace('_', ' ').upper()
        draw.text((10, y_offset), title, fill=(0, 0, 100), font=font_bold)
        
        y_offset += 25
        draw.text((10, y_offset), f"Holder: {name}", fill=(0, 0, 0), font=font_small)
        y_offset += 15
        draw.text((10, y_offset), f"NID: {national_id}", fill=(0, 0, 0), font=font_small)

        # Category Specific Logic
        y_offset += 25
        if doc_type in ['salary_slip', 'bank_statement']:
            amount = random.randint(300000, 2500000)
            draw.text((10, y_offset), f"Net Amount: {amount:,} RWF", fill=(0, 0, 0), font=font_small)
            if not is_valid:
                # Pixel-level manipulation: Overlap different font for amount (Forgery 101)
                draw.text((70, y_offset), f"{amount*2:,}", fill=(20, 20, 20), font=font_small) 
        
        elif doc_type == 'certificate_of_celibacy':
            draw.text((10, y_offset), "Status: SINGLE / CELIBATAIRE", fill=(0, 0, 0), font=font_small)
            if not is_valid:
                # Tampered: Change "SINGLE" to "SINGLE" but with slight misalignment
                draw.text((45, y_offset), "SINGLE", fill=(0, 0, 0), font=font_small)

        elif doc_type in ['academic_transcript', 'notarial_act']:
            draw.text((10, y_offset), "Verification Code: RW-" + str(random.randint(1000,9999)), fill=(0, 0, 0), font=font_small)
            if not is_valid:
                # Patch Forgery: Add a white rectangle then new text
                draw.rectangle([60, y_offset-2, 120, y_offset+10], fill=(255, 255, 255))
                draw.text((62, y_offset), "VOID", fill=(200, 0, 0), font=font_small)

        # Forensic Artifacts for 'invalid' documents
        if not is_valid:
            # Random "Cloning" artifacts or "Noise"
            if random.random() > 0.5:
                draw.text((150, 150), "STAMPED", fill=(0, 0, 150), font=font_small)
                # Tampering: Double stamp (cloning error)
                draw.text((152, 151), "STAMPED", fill=(20, 20, 170), font=font_small)
            else:
                # Splicing: Add a mismatched text block
                draw.rectangle([10, 180, 210, 210], outline=(180, 180, 180), width=1)
                draw.text((15, 185), "AUTHORIZED SIGNATURE", fill=(0, 0, 0), font=font_small)

        return img

    def generate_from_registry(self, records, samples_per_record=5):
        """Generates documents using real identities from MySQL."""
        print(f"🚀 Starting dataset generation from {len(records)} identities...")
        
        for record in records:
            name = f"{record['first_name']} {record['last_name']}"
            nid = record['national_id']
            
            for _ in range(samples_per_record):
                doc_type = random.choice(self.doc_types)
                
                # Generate Valid
                img_valid = self._generate_base_image(doc_type, name, nid, is_valid=True)
                valid_path = self.output_dir / doc_type / 'valid' / f"valid_{nid}_{random.randint(1000,9999)}.jpg"
                img_valid.save(valid_path)
                
                # Generate Invalid (Tampered version of same ID)
                img_invalid = self._generate_base_image(doc_type, name, nid, is_valid=False)
                invalid_path = self.output_dir / doc_type / 'invalid' / f"tamp_{nid}_{random.randint(1000,9999)}.jpg"
                img_invalid.save(invalid_path)

        print(f"✅ Generation complete. Samples saved to {self.output_dir}")

    def generate_dataset(self, num_samples_per_type=1500, noise_levels=['medium']):
        """Fallback method for generic generation if registry is empty."""
        names = ["Umuhoza Alice", "Kamanzi Jean", "Murenzi Eric", "Irakoze Gad"]
        for dt in self.doc_types:
            for i in range(num_samples_per_type):
                name = random.choice(names)
                nid = f"11990{random.randint(10000000000, 99999999999)}"
                
                status = 'valid' if i % 2 == 0 else 'invalid'
                img = self._generate_base_image(dt, name, nid, is_valid=(status == 'valid'))
                path = self.output_dir / dt / status / f"gen_{i}.jpg"
                img.save(path)
