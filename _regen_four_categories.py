from pathlib import Path
from datetime import datetime
import shutil
import random

from synthetic_document_generator import RwandanDocumentGenerator

base = Path(r"c:/xampp/htdocs/aipowered")
categories = ["birth_certificate", "business_license", "marriage_certificate", "nida_id"]
name_pool = [
    "Umuhoza Alice", "Kamanzi Jean", "Murenzi Eric", "Irakoze Gad", "Mukamana Rose",
    "Uwimana Diane", "Ndayisaba Claude", "Habimana Eric", "Ingabire Aline", "Nsengiyumva Patrick"
]

def move_category_backups_out(dataset_path: Path):
    stamp = datetime.now().strftime("%Y%m%d_%H%M%S")
    archive_root = dataset_path / f"_category_backup_archive_{stamp}"
    moved = 0

    for cat in categories:
        cat_path = dataset_path / cat
        if not cat_path.exists():
            continue

        for d in [p for p in cat_path.iterdir() if p.is_dir() and p.name.startswith("invalid_backup_")]:
            dest = archive_root / cat / d.name
            dest.parent.mkdir(parents=True, exist_ok=True)
            shutil.move(str(d), str(dest))
            moved += 1

    return moved, archive_root

def regenerate_category_set(dataset_name: str, profile: str, per_category: int = 500):
    dataset_path = base / dataset_name
    gen = RwandanDocumentGenerator(output_dir=str(dataset_path), sync_to_training_dirs=False)

    # Ensure target category folders exist.
    for cat in categories:
        (dataset_path / cat / "valid").mkdir(parents=True, exist_ok=True)
        (dataset_path / cat / "invalid").mkdir(parents=True, exist_ok=True)

    for cat in categories:
        # Clear existing files in valid/invalid for the four categories only.
        for status in ["valid", "invalid"]:
            folder = dataset_path / cat / status
            for f in folder.glob("*"):
                if f.is_file():
                    f.unlink()

        # Generate fresh paired samples for this category.
        for i in range(per_category):
            name = random.choice(name_pool)
            nid = f"11990{random.randint(10000000000, 99999999999)}"

            v_img = gen._generate_base_image(cat, name, nid, is_valid=True, distortion_profile=profile)
            iv_img = gen._generate_base_image(cat, name, nid, is_valid=False, distortion_profile=profile)

            v_name = f"gen_{i}_{profile}.jpg"
            iv_name = f"gen_{i}_{profile}.jpg"
            v_img.save(dataset_path / cat / "valid" / v_name)
            iv_img.save(dataset_path / cat / "invalid" / iv_name)

    return dataset_path

# 1) Move old invalid_backup_* out of category folders
for ds in ["fixed_synthetic", "high_risk_dataset"]:
    moved, archive = move_category_backups_out(base / ds)
    print(f"{ds}: moved {moved} old backup dirs to {archive.name}")

# 2) Fresh regenerate requested categories
regenerate_category_set("fixed_synthetic", profile="medium", per_category=500)
regenerate_category_set("high_risk_dataset", profile="high", per_category=500)

print("REGEN_FOUR_CATEGORIES_COMPLETE")
