CREATE TRIGGER `before_registrant_insert` BEFORE INSERT ON `registrants_staging`
    FOR EACH ROW SET NEW.reg_id = (Select CONCAT("ACM",lPAD((SELECT MAX(id)+1 from registrants_staging),4,"0")));
END


CREATE TRIGGER `before_batch_insert` BEFORE INSERT ON `batches`
    FOR EACH ROW BEGIN
    SET NEW.batch_no = (Select CONCAT("BACM",LPAD((SELECT MAX(id)+1 from batches),6,"0")));
END