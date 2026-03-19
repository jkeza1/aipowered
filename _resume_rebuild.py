from pathlib import Path
from PIL import Image, ImageEnhance, ImageDraw
import random
import shutil
from datetime import datetime

BASE = Path(r"C:\xampp\htdocs\aipowered")
DATASETS = ["high_risk_dataset", "fixed_synthetic"]
TARGET_DOCS = ["business_license", "birth_certificate", "marriage_certificate", "nida_id"]
random.seed(99)
stamp = datetime.now().strftime("%Y%m%d_%H%M%S")

# Fast lightweight tamper to avoid long processing

def tamper_fast(img):
    out = img.convert("RGB")
    w, h = out.size
    d = ImageDraw.Draw(out)

    pw = max(24, int(w * 0.2))
    ph = max(10, int(h * 0.07))
    x = random.randint(6, max(6, w - pw - 6))
    y = random.randint(int(h * 0.2), max(int(h * 0.2), h - ph - 8))
    bg = random.randint(230, 250)
    d.rectangle([x, y, x + pw, y + ph], fill=(bg, bg, bg))
    d.text((x + 3, y + 1), "AMENDED", fill=(25, 25, 25))

    if random.random() < 0.65:
        sx = random.randint(int(w * 0.55), max(int(w * 0.55), w - 58))
        sy = random.randint(int(h * 0.55), max(int(h * 0.55), h - 22))
        d.text((sx, sy), "STAMPED", fill=(35, 35, 130))

    return ImageEnhance.Contrast(out).enhance(1.03)

for ds in DATASETS:
    root = BASE / ds
    print(f"\n=== Resume {ds} ===")
    for doc in TARGET_DOCS:
        vdir = root / doc / 'valid'
        idir = root / doc / 'invalid'
        if not vdir.exists():
            print(f"[SKIP] {doc} missing valid")
            continue
        valid_files = sorted([p for p in vdir.glob('*') if p.is_file()])
        if not valid_files:
            print(f"[SKIP] {doc} no valid files")
            continue

        idir.mkdir(parents=True, exist_ok=True)
        existing = [p for p in idir.glob('*') if p.is_file()]
        if existing:
            # If invalid already perfectly rebuilt to match valid count and naming, skip
            tamp_like = [p for p in existing if p.name.startswith('tamp_')]
            if len(existing) == len(valid_files) and len(tamp_like) == len(existing):
                print(f"[OK] {doc} already aligned ({len(existing)})")
                continue
            backup = root / doc / f"invalid_backup_{stamp}"
            backup.mkdir(parents=True, exist_ok=True)
            for p in existing:
                shutil.move(str(p), str(backup / p.name))
            print(f"[BACKUP] {doc}: moved {len(existing)} -> {backup.name}")

        created = 0
        for vf in valid_files:
            try:
                with Image.open(vf) as im:
                    out = tamper_fast(im)
                    out.save(idir / f"tamp_{vf.stem}.jpg", quality=90)
                    created += 1
            except Exception:
                pass
        print(f"[DONE] {doc}: valid={len(valid_files)} invalid={created}")
