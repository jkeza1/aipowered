from pathlib import Path
import random
from synthetic_document_generator import RwandanDocumentGenerator

base = Path(r'c:/xampp/htdocs/aipowered')
out = base / 'high_risk_dataset'
categories = ['nida_id', 'marriage_certificate', 'business_license']

names = [
    'Umutoni Aline', 'Niyonzima Claude', 'Mukandayisenga Diane',
    'Twagirimana Eric', 'Habimana Chantal', 'Nkundimana Patrick'
]

gen = RwandanDocumentGenerator(output_dir=str(out), sync_to_training_dirs=False)

for cat in categories:
    (out / cat / 'valid').mkdir(parents=True, exist_ok=True)
    (out / cat / 'invalid').mkdir(parents=True, exist_ok=True)

    # Fill to 500/500 to align with fixed_synthetic for these categories.
    valid_existing = len([p for p in (out / cat / 'valid').glob('*') if p.is_file()])
    invalid_existing = len([p for p in (out / cat / 'invalid').glob('*') if p.is_file()])

    target = 500
    for i in range(valid_existing, target):
        name = random.choice(names)
        nid = f"11990{random.randint(10000000000, 99999999999)}"
        img = gen._generate_base_image(cat, name, nid, is_valid=True, distortion_profile='high')
        img.save(out / cat / 'valid' / f'{cat}_valid_{i:04d}.jpg')

    for i in range(invalid_existing, target):
        name = random.choice(names)
        nid = f"11990{random.randint(10000000000, 99999999999)}"
        img = gen._generate_base_image(cat, name, nid, is_valid=False, distortion_profile='high')
        img.save(out / cat / 'invalid' / f'{cat}_invalid_{i:04d}.jpg')

    print(f'{cat}: valid={len([p for p in (out / cat / "valid").glob("*") if p.is_file()])}, invalid={len([p for p in (out / cat / "invalid").glob("*") if p.is_file()])}')

print('HIGH_RISK_FILL_COMPLETE')
