from pathlib import Path
from PIL import Image, ImageEnhance, ImageFilter, ImageDraw
import random
import shutil
from datetime import datetime

BASE = Path(r"C:\xampp\htdocs\aipowered")
DATASETS = ["high_risk_dataset", "fixed_synthetic"]
TARGET_DOCS = ["business_license", "birth_certificate", "marriage_certificate", "nida_id"]

random.seed(42)
stamp = datetime.now().strftime("%Y%m%d_%H%M%S")

def tamper_from_valid(img: Image.Image) -> Image.Image:
    out = img.convert("RGB").copy()
    w, h = out.size
    d = ImageDraw.Draw(out)

    # 1) local patch/overwrite area (simulates edited field)
    patch_w = max(28, int(w * 0.23))
    patch_h = max(12, int(h * 0.08))
    x1 = random.randint(8, max(8, w - patch_w - 8))
    y1 = random.randint(int(h * 0.25), max(int(h * 0.25), h - patch_h - 10))
    bg = random.randint(232, 252)
    d.rectangle([x1, y1, x1 + patch_w, y1 + patch_h], fill=(bg, bg, bg))

    # 2) inserted replacement text with slight blur to mimic splice
    for i, txt in enumerate(["AMENDED", "COPY", "REVISED"]):
        if random.random() < 0.55:
            d.text((x1 + 3, y1 + 1 + i * 8), txt, fill=(20 + i * 10, 20, 20))

    # 3) stamp-like overlay with mild offset
    if random.random() < 0.7:
        sx = random.randint(int(w * 0.55), max(int(w * 0.55), w - 60))
        sy = random.randint(int(h * 0.55), max(int(h * 0.55), h - 25))
        d.text((sx, sy), "STAMPED", fill=(30, 30, 130))
        d.text((sx + 1, sy + 1), "STAMPED", fill=(55, 55, 165))

    # 4) tiny contrast/noise-like perturbation
    out = ImageEnhance.Contrast(out).enhance(1.05)
    if random.random() < 0.5:
        out = out.filter(ImageFilter.GaussianBlur(radius=0.35))

    return out

for ds in DATASETS:
    root = BASE / ds
    print(f"\n=== Processing {ds} ===")
    for doc in TARGET_DOCS:
        doc_dir = root / doc
        vdir = doc_dir / "valid"
        idir = doc_dir / "invalid"
        if not vdir.exists():
            print(f"[SKIP] {doc}: missing valid folder")
            continue

        valid_files = sorted([p for p in vdir.glob('*') if p.is_file()])
        if not valid_files:
            print(f"[SKIP] {doc}: no valid files")
            continue

        # Backup existing invalid set if present and non-empty
        if idir.exists():
            existing_invalid = [p for p in idir.glob('*') if p.is_file()]
            if existing_invalid:
                backup = doc_dir / f"invalid_backup_{stamp}"
                backup.mkdir(parents=True, exist_ok=True)
                for p in existing_invalid:
                    shutil.move(str(p), str(backup / p.name))
                print(f"[BACKUP] {doc}: moved {len(existing_invalid)} old invalid files -> {backup.name}")
        else:
            idir.mkdir(parents=True, exist_ok=True)

        # Rebuild invalid as tampered counterpart of each valid image
        created = 0
        for vf in valid_files:
            try:
                img = Image.open(vf)
                ti = tamper_from_valid(img)
                out_name = f"tamp_{vf.stem}.jpg"
                ti.save(idir / out_name, quality=95)
                created += 1
            except Exception as e:
                print(f"[WARN] {doc}: failed {vf.name} ({e})")

        print(f"[DONE] {doc}: valid={len(valid_files)} invalid_rebuilt={created}")
