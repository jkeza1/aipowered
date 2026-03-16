-- Comprehensive Database Fix for All AI Services
-- 1. Info Tables (Service Metadata)
CREATE TABLE IF NOT EXISTS salaryslipinfo (id INT AUTO_INCREMENT PRIMARY KEY, service_name VARCHAR(255), description TEXT, requirements TEXT, processing_time VARCHAR(50), price INT, currency VARCHAR(10), provided_by VARCHAR(100), status VARCHAR(20) DEFAULT 'Active');
CREATE TABLE IF NOT EXISTS bankstatementinfo (id INT AUTO_INCREMENT PRIMARY KEY, service_name VARCHAR(255), description TEXT, requirements TEXT, processing_time VARCHAR(50), price INT, currency VARCHAR(10), provided_by VARCHAR(100), status VARCHAR(20) DEFAULT 'Active');
CREATE TABLE IF NOT EXISTS academictranscriptinfo (id INT AUTO_INCREMENT PRIMARY KEY, service_name VARCHAR(255), description TEXT, requirements TEXT, processing_time VARCHAR(50), price INT, currency VARCHAR(10), provided_by VARCHAR(100), status VARCHAR(20) DEFAULT 'Active');
CREATE TABLE IF NOT EXISTS courtjudgmentinfo (id INT AUTO_INCREMENT PRIMARY KEY, service_name VARCHAR(255), description TEXT, requirements TEXT, processing_time VARCHAR(50), price INT, currency VARCHAR(10), provided_by VARCHAR(100), status VARCHAR(20) DEFAULT 'Active');
CREATE TABLE IF NOT EXISTS celibacyinfo (id INT AUTO_INCREMENT PRIMARY KEY, service_name VARCHAR(255), description TEXT, requirements TEXT, processing_time VARCHAR(50), price INT, currency VARCHAR(10), provided_by VARCHAR(100), status VARCHAR(20) DEFAULT 'Active');
CREATE TABLE IF NOT EXISTS contractinfo (id INT AUTO_INCREMENT PRIMARY KEY, service_name VARCHAR(255), description TEXT, requirements TEXT, processing_time VARCHAR(50), price INT, currency VARCHAR(10), provided_by VARCHAR(100), status VARCHAR(20) DEFAULT 'Active');
CREATE TABLE IF NOT EXISTS criminalrecordinfo_serv (id INT AUTO_INCREMENT PRIMARY KEY, service_name VARCHAR(255), description TEXT, requirements TEXT, processing_time VARCHAR(50), price INT, currency VARCHAR(10), provided_by VARCHAR(100), status VARCHAR(20) DEFAULT 'Active');
CREATE TABLE IF NOT EXISTS notarialactinfo (id INT AUTO_INCREMENT PRIMARY KEY, service_name VARCHAR(255), description TEXT, requirements TEXT, processing_time VARCHAR(50), price INT, currency VARCHAR(10), provided_by VARCHAR(100), status VARCHAR(20) DEFAULT 'Active');
CREATE TABLE IF NOT EXISTS poainfo (id INT AUTO_INCREMENT PRIMARY KEY, service_name VARCHAR(255), description TEXT, requirements TEXT, processing_time VARCHAR(50), price INT, currency VARCHAR(10), provided_by VARCHAR(100), status VARCHAR(20) DEFAULT 'Active');

-- 2. Populate Notarial Act Info (Specifically fixing the reported error)
INSERT INTO notarialactinfo (service_name, description, requirements, processing_time, price, currency, provided_by) 
SELECT 'Notarial Act Authentication', 'Legal certification of documents by a public notary.', '1. Original Document\n2. ID Copy', '1 Day', 5000, 'RWF', 'MINIJUST'
WHERE NOT EXISTS (SELECT 1 FROM notarialactinfo LIMIT 1);

-- 3. Application Tables (User Submissions with Forensic tracking)
CREATE TABLE IF NOT EXISTS applicationnotarialact (id INT AUTO_INCREMENT PRIMARY KEY, full_name VARCHAR(255), national_id VARCHAR(20), act_type VARCHAR(100), document_path VARCHAR(512), service_name VARCHAR(255), status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending', ai_forgery_score FLOAT, ai_verdict VARCHAR(50), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS applicationpowerofattorney (id INT AUTO_INCREMENT PRIMARY KEY, full_name VARCHAR(255), national_id VARCHAR(20), appointee_name VARCHAR(255), document_path VARCHAR(512), service_name VARCHAR(255), status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending', ai_forgery_score FLOAT, ai_verdict VARCHAR(50), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS applicationcourtjudgment (id INT AUTO_INCREMENT PRIMARY KEY, full_name VARCHAR(255), national_id VARCHAR(20), case_number VARCHAR(100), ruling_year INT, document_path VARCHAR(512), service_name VARCHAR(255), status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending', ai_forgery_score FLOAT, ai_verdict VARCHAR(50), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
