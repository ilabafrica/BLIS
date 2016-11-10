INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Red blood cells (RBC)'), '12',  '100',  '0', '4.4', '5.7',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Red blood cells (RBC)'), '12',  '100',  '1', '4.0', '5.2',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Hematocrit'), '12',  '100',  '0', '42.0', '52.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Hematocrit'), '12',  '100',  '1', '37.0', '46.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Haemoglobin'), '12',  '100',  '0', '14.0', '17.4',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Haemoglobin'), '12',  '100',  '1', '12.3', '15.7',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'White blood cells (WBC)'), '12',  '100',  '2', '4.0', '10.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Neutrophils'), '12',  '100',  '2', '45.0', '75.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Lymphocytes'), '12',  '100',  '2', '16.0', '46.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Monocytes'), '12',  '100',  '2', '4.0', '11.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Eosinophils'), '12',  '100',  '2', '0.0', '8.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Basophils'), '12',  '100',  '2', '0.0', '3.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Erythrocyte sedimentation rate (ESR)'), '0',  '100',  '0', '0.0', '6.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Erythrocyte sedimentation rate (ESR)'), '12',  '100',  '1', '0.0', '10.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Haemoglobin'), '12',  '100',  '0', '14.0', '17.4',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Haemoglobin'), '17',  '100',  '1', '12.3', '15.7',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Reticulocyte count'), '17',  '100',  '2', '0.5', '2.5',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Sickling test'), '1',  '100', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Sickling test'), '1',  '100', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Blood grouping'), '',  '', '', '', '',  'Blood Group A+','Blood Group A+');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Blood grouping'), '',  '', '', '', '',  'AB+','AB+');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Blood grouping'), '',  '', '', '', '',  'B+','B+');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Blood grouping'), '',  '', '', '', '',  'O+A-','O+A-');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Blood grouping'), '',  '', '', '', '',  'AB-','AB-');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Blood grouping'), '',  '', '', '', '',  'B-','B-');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Blood grouping'), '',  '', '', '', '',  'O-','O-');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Du test'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Cross Match'), '',  '', '', '', '',  'Compatible','Compatible');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Cross Match'), '',  '', '', '', '',  'Incompatible','Incompatible');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Indirect coombs test'), '',  '', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Indirect coombs test'), '',  '', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Direct coombs test'), '',  '', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Direct coombs test'), '',  '', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Falciparum'), '',  '', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Falciparum'), '',  '', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Ovale'), '',  '', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Ovale'), '',  '', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Malariae'), '',  '', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Malariae'), '',  '', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Vivax'), '',  '', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Vivax'), '',  '', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'PH'), '',  '',  '2', '5.0', '7.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Specific Gravity'), '0',  '100',  '2', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Glucose'), '0',  '100',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Ketones'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Nitrites'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Leucocytes'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Proteins'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Urobilinogen'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Blood'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Bilirubin'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Pus cells'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Schistosoma haematobium'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Trichomona Vaginalis'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Yeast cells'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Red blood cells (RBC)'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Bacteria'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Spermatozoa'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Urine Culture'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Taenia spp.'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'H. nana'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'H. diminuta'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Hookworm'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Roundworms'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'S. mansoni'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Trichuris trichiura'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Strongyloides stercoralis'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Isospora belli'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'E hystolytica'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Giardia lamblia'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Stool culture'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Pus swab culture'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Pus swab gram stain'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Throat swab culture'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Throat swab gram stain'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'High vaginal swab (HVS) culture'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'High vaginal swab (HVS) gram stain'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Urethral swab culture'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Urethral swab gram stain'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Ascitic fluid  culture'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Pleural effusion for culture'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'CSF  culture'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'CSF for Indian ink test'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Sputum for AFB'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'MDR TB'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'CSF  glucose analysis'), '',  '',  '2', '2.8', '4.4',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'CSF protein analysis'), '0',  '100',  '2', '20.0', '40.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'SGOT/AST'), '0',  '100',  '2', '0.0', '35.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'SGPT/ALT'), '0',  '100',  '2', '3.0', '36.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Total Protein'), '0',  '100',  '2', '60.0', '80.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Albumin'), '0',  '100',  '2', '3.5', '5.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Total Bilirubin'), '0',  '100',  '2', '0.0', '1.5',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Direct Bilirubin'), '0',  '100',  '2', '0.0', '0.4',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Alkaline Phosphatase'), '0',  '100',  '2', '35.0', '100.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Gamma GT'), '0',  '100',  '0', '8.0', '61.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Gamma GT'), '0',  '100',  '1', '5.0', '36.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Urea'), '0',  '100',  '2', '2.5', '8.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Potassium'), '0',  '100',  '2', '3.5', '5.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Sodium'), '0',  '100',  '2', '135.0', '145.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Chloride'), '0',  '100',  '2', '96.0', '105.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Creatinine'), '0',  '100',  '0', '70.0', '120.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Creatinine'), '0',  '100',  '1', '50.0', '90.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Phosphorous'), '0',  '100',  '2', '0.8', '1.5',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Uric acid'), '0',  '100',  '2', '180.0', '420.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Calcium'), '0',  '100',  '2', '8.7', '10.3',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Amylase'), '0',  '100',  '2', '0.0', '160.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Total cholestrol'), '0',  '100',  '2', '0.0', '5.2',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'LDL'), '0',  '100',  '2', '0.0', '2.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'HDL'), '0',  '100',  '2', '0.0', '1.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Triglycerides'), '0',  '100',  '2', '0.0', '2.2',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Fasting blood sugar'), '0',  '100',  '2', '3.3', '5.8',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Random Blood sugar'), '0',  '100',  '2', '4.4', '7.8',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'OGTT'), '0',  '100',  '2', 'n/a', 'n/a',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'HBA1C'), '0',  '100',  '2', '4.0', '6.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Occult blood test'), '0',  '100', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Occult blood test'), '0',  '100', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Thyroid stimulating hormone (TSH)'), '',  '',  '2', '0.4', '5.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Thyroxine (T4)'), '0',  '100',  '2', '0.7', '1.2',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Triiodothyromine (T3)'), '0',  '100',  '2', '227.0', '422.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Pregnancy test'), '0',  '100', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Pregnancy test'), '0',  '100', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Rapid Plasma Reagin (RPR)'), '',  '', '', '', '',  'Reactive','Reactive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Rapid Plasma Reagin (RPR)'), '',  '', '', '', '',  'Non-reactive','Non-reactive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Helicobacter pylori'), '',  '', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Helicobacter pylori'), '',  '', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Hepatitis B test (HBs Ag)'), '',  '', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Hepatitis B test (HBs Ag)'), '',  '', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Hepatitis C test'), '',  '', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Hepatitis C test'), '',  '', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Rheumatoid factor'), '',  '', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Rheumatoid factor'), '',  '', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'ASOT test'), '',  '', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'ASOT test'), '',  '', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'PSA screening'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'HIV rapid testing'), '',  '', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'HIV rapid testing'), '',  '', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'HIV rapid testing'), '',  '', '', '', '',  'Discrepant','Discrepant');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'HIV rapid testing'), '',  '', '', '', '',  'Discordant','Discordant');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Early infant diagnosis'), '',  '', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Early infant diagnosis'), '',  '', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'CD4 count'), '',  '',  '2', ' 500', '1600.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'CD4 %'), '0',  '100',  '2', '25.0', '65.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'HIV ELISA'), '0',  '100', '', '', '',  'Positive','Positive');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'HIV ELISA'), '0',  '100', '', '', '',  'Negative','Negative');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Viral Load'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Bleeding time'), '',  '',  '2', '1.0', '9.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Clotting time'), '0',  '100',  '2', '11.0', '13.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Prothrombin test'), '0',  '100',  '2', 'n/a', 'n/a',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Partial prothrombin test'), '0',  '100',  '2', '30.0', '50.0',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Acid Phosphatase'), '0',  '100',  '2', '0.0', '0.8',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Bence Jones proteins'), '0',  '100',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Vibrio cholerae'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Blood culture'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Water'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Food'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Borelia'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Microfilariae'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Trypanosomes'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'HB electrophoresis'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Bone marrow aspirates'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Peripheral Blood films'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Fungi'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Tissue Impression'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Fine Needle aspirates'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Pap Smear'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Ascitic fluid'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'CSF'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Pleural fluid'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Cervix'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Prostrate'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Breast'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Ovarian cyst'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Fibroids'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Lymph nodes'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Hepatitis A test'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Brucella test'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Widal Test'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'TPHA'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Cryptococcal antigen'), '',  '',  '', '', '',  '','');
INSERT INTO iblis.measure_ranges(measure_id, age_min, age_max, gender, range_lower, range_upper, alphanumeric, interpretation) 
 VALUES ( (SELECT id FROM iblis.measures WHERE name = 'Helicobacter pylori'), '',  '',  '', '', '',  '','');
