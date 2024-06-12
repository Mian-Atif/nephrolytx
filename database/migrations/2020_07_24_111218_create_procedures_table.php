<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE active_patients_count(IN practiceId INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), IN cptCode VARCHAR(15))
BEGIN
       
       SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceid);
	SET @var_practiceid = practiceid;
    
	SET @queryText ="SELECT COUNT(DISTINCT account_nbr) as activePts FROM analytic_data WHERE Date_of_Service>= DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH) AND practice_id=?";
	
	 IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	 
	 PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @start_date,@start_date,@var_practiceid;
	 DEALLOCATE PREPARE statement_1;
	 
    END');


        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE update_practice_providers(IN practiceid INT)
BEGIN
    
	DECLARE finished INTEGER DEFAULT 0;
	DECLARE providerName VARCHAR(1000);
	
	
	DECLARE providers 
	   CURSOR FOR 
		SELECT DISTINCT provider FROM analytic_data ad WHERE provider NOT IN
		(
		SELECT p.middle_name FROM persons p INNER JOIN practice_doctors pd ON(p.id=pd.person_id) WHERE practice_id=practiceid
		) AND practice_id=practiceid;
		
		
	DECLARE CONTINUE HANDLER 
          FOR NOT FOUND SET finished = 1;
          
	
			
	OPEN providers;
    
		getProviders: LOOP
				
			FETCH providers INTO providerName;
						
			IF finished = 1 THEN 
			    LEAVE getProviders;
			END IF;
		 
			INSERT INTO persons (middle_name) VALUES(providerName);
			SELECT LAST_INSERT_ID() INTO @personId;
			INSERT INTO practice_doctors(person_id,practice_id) VALUES(@personId,practiceid);
			
		END LOOP getProviders;
	CLOSE providers;
    
	SELECT GROUP_CONCAT(pd.id) INTO @ids FROM persons p INNER JOIN practice_doctors pd ON(p.id=pd.person_id) WHERE practice_id=practiceid
		AND p.middle_name NOT IN
		(SELECT DISTINCT provider FROM analytic_data ad WHERE practice_id=practiceid);
		
		IF @ids IS NOT NULL THEN
			SET @queryText ="delete from practice_doctors where id in(";
			SET @queryText = CONCAT(@queryText,@ids,")");
			PREPARE statement_1 FROM @queryText;
			EXECUTE statement_1 ;
			DEALLOCATE PREPARE statement_1;
		END IF;
		
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE update_practice_payers(IN practiceid INT)
BEGIN
	DELETE FROM practice_payers WHERE practice_id=practiceid;
	INSERT INTO practice_payers(practice_id,payer_name) SELECT DISTINCT practiceid,Primary_Insurance_Name FROM analytic_data ad WHERE ad.practice_id=practiceid;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE update_practice_locations(IN practiceid INT)
BEGIN
	DELETE FROM practice_locations WHERE practice_id=practiceid;
	INSERT INTO practice_locations(practice_id,location_name,location_map) SELECT DISTINCT practiceid,Service_Location,Service_Location FROM analytic_data ad WHERE ad.practice_id=practiceid;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE update_cptcode_prices(IN practiceid INT)
BEGIN
    
	UPDATE analytic_data ad 
	INNER JOIN cptcode_prices cp ON( ad.cptcode=cp.cpt_code  AND cp.practice_id IS NULL)
	SET ad.cptcode_amount=cp.par_amount
	WHERE ad.practice_id=practiceid;
	
	UPDATE analytic_data ad 
	INNER JOIN cptcode_prices cp ON( ad.cptcode=cp.cpt_code  AND cp.practice_id=practiceid)
	SET ad.cptcode_amount=cp.par_amount
	WHERE ad.practice_id=practiceid;
	
	UPDATE analytic_data ad INNER JOIN cptcode_insurance_prices cip ON(ad.cptcode=cip.cptcode AND ad.practice_id=cip.practice_id AND ad.primary_insurance_name=insurance_name)
	SET ad.cptcode_amount=cip.par_amount	
	WHERE ad.practice_id=practiceid;
	
	
	UPDATE  analytic_data ad INNER JOIN cptcodeandrvu c ON(c.cptcode=ad.cptcode)
	SET ad.cptcode_description=c.description,ad.work_RVU=c.workRVU,ad.practice_RVU=c.practiceRVU,
	ad.malpractice_RVU=c.malpracticeRVU,ad.total_RVU=c.totalRVU
	WHERE ad.practice_id=practiceid;
	
    END');
        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE underpaid_cases(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), IN cptCode VARCHAR(15), IN monthyear VARCHAR(8))
BEGIN
	
	SET @var_practiceid = practiceid;
	SET @monthwithyear = monthyear;
	
	SET @queryText ="SELECT account_nbr,Patient_Name,DATE_FORMAT(Date_of_Service, \'%m/%d/%Y\') AS Date_of_Service,Primary_Insurance_Name,cptcode,Billed_Amount as chargeAmount,cptcode_amount as expectedAllowed,Primary_Insurance_Allowance as actualAllowed,cptcode_amount-Primary_Insurance_Allowance as variance FROM analytic_data ad where Primary_Insurance_Allowance > (Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment) and practice_id=? and CONCAT_WS('-',DATE_FORMAT(ad.Date_of_Service,\'%b\'),DATE_FORMAT(ad.Date_of_Service, \'%y\'))=?" ;
		
		-- cptcode_amount > 
		
		IF serviceLocation <>"" THEN
			SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
		 END IF;
		
		IF providerName <>"" THEN
			SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
		 END IF;
		 
		 IF insuranceCompanyName <>"" THEN
			SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
		 END IF;
		 IF cptCode <>"" THEN
			SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
		 END IF;
			 
		 PREPARE statement_1 FROM @queryText;
		 EXECUTE statement_1 USING @var_practiceid,@monthwithyear;
		 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE service_analysis_cpt_wise(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15))
BEGIN
	SET @var_practiceid = practiceid;
	SET @start_date = (SELECT IFNULL(MAX(Date_of_Service),CURDATE()) FROM analytic_data WHERE practice_id=practiceid);
	
	SET @SQL = (
    SELECT GROUP_CONCAT(DISTINCT 
    
		CONCAT(
		    "ifnull(sum(case when month(Date_of_Service)=\'", MONTH(Date_of_Service), "\' then `units` end),0) as `", CONCAT_WS(\'-\',DATE_FORMAT(Date_of_Service,\'%b\'),YEAR(Date_of_Service)), "`"
		)
        ORDER BY YEAR(Date_of_Service),MONTH(Date_of_Service)
	    ) 
	    FROM analytic_data WHERE practice_id=practiceid AND Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 11 MONTH) AND @start_date
	);
	
	IF @SQL IS NOT NULL THEN
		SET @SQL = CONCAT("select cptCode, ", @SQL, " from analytic_data ad WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH) AND ? ");
		
		IF serviceLocation <> "" THEN
			SET @SQL = CONCAT(@SQL," and Service_Location=\'", serviceLocation,"\'");
		 END IF;
		
		IF providerName <> "" THEN
			SET @SQL = CONCAT(@SQL," and provider=\'", providerName,"\'");
		 END IF;
		 
		 IF insuranceCompanyName <> "" THEN
			SET @SQL = CONCAT(@SQL," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
		 END IF;
		 IF cptCode <> "" THEN
			SET @SQL = CONCAT(@SQL," and cptcode=\'", cptCode,"\'");
		 END IF;
			
		SET @SQL = CONCAT(@SQL,"group by cptCode");
		
		PREPARE stmt FROM @SQL;
		EXECUTE stmt USING @var_practiceid,@start_date,@start_date,@start_date;
		DEALLOCATE PREPARE stmt;
	END IF;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE service_analysis(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15))
BEGIN
	SET @var_practiceid = practiceid;
	SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceid);
	
	SET @queryText ="SELECT CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)) AS monthNme,ss.serviceName, SUM(units) AS BilledUnits,
	round(SUM(Billed_Amount),2) AS chargeAmount,
	SUM(CASE WHEN Primary_Insurance_Payment>0 AND Primary_Contractual_Adjustment <> 0 THEN units ELSE 0 END) AS ProcessedUnits,
	SUM(units)-SUM(CASE WHEN Primary_Insurance_Payment>0 AND Primary_Contractual_Adjustment <> 0 THEN units ELSE 0 END) AS openUnits,
	round(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment),2) AS collection,
	round(SUM(Insurance_Balance)+SUM(Patient_Balance),2) AS openBalance,
	round((SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) )/SUM(units),2)  AS AvgCollectionPerUnit
	FROM analytic_data ad RIGHT JOIN 
	(
	SELECT  sc.cptcode,s.serviceName,s.orderby FROM service_code sc INNER JOIN service s ON(s.id=sc.service_id)
	) ss ON(ss.cptcode=ad.cptcode)
	WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH) AND ?";
	
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
			 
	SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ss.serviceName");
	SET @queryText = CONCAT(@queryText," ORDER BY YEAR(ad.Date_of_Service),MONTH(ad.Date_of_Service),ss.orderby");
	
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@start_date,@start_date;
	 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE charge_payment_analysis(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), IN cptCode VARCHAR(15))
BEGIN
/* use in Month wise report*/
	
	
	SET @start_date = (select max(Date_of_Service) from analytic_data where practice_id=practiceid);
	
	set @var_practiceid = practiceid;
	SET @queryText =\'SELECT CONCAT_WS("-",DATE_FORMAT(ad.Date_of_Service,"%b"),DATE_FORMAT(ad.Date_of_Service, "%y")) AS "MONTH",COUNT(ad.id) AS "No_Of_Claims" ,SUM(Billed_Amount) AS "Total_Charges_Amount"\r\n\t\t\t,ROUND(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment),0) AS "Actual_Collection",ROUND(SUM(ad.cptcode_amount),0) AS "Projected_Collection",\r\n\t\t\t(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment)) -SUM(ad.cptcode_amount)  AS Varience,\r\n\t\t\tROUND((SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) )/SUM(Billed_Amount) *100,2) AS "Collection_age",\r\n\t\t\tSUM(Primary_Contractual_Adjustment)+SUM(Secondary_Contractual_Adjustment) AS "Contractual_Adj"\r\n\t\t\tFROM analytic_data ad \r\n\t\t\tWHERE ad.practice_id=? and ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH) AND ?\';
			
			 IF serviceLocation <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
			 END IF;
			
			IF providerName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
			 END IF;
			 
			 IF insuranceCompanyName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
			 END IF;
			 IF cptCode <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
			 END IF;
			 
			SET @queryText = CONCAT(@queryText,\' GROUP BY CONCAT_WS("-",DATE_FORMAT(ad.Date_of_Service,"%b"),DATE_FORMAT(ad.Date_of_Service, "%y"))\');
			SET @queryText = CONCAT(@queryText," ORDER BY YEAR(ad.Date_of_Service),MONTH(ad.Date_of_Service)");
			
			PREPARE statement_1 FROM @queryText;
			 EXECUTE statement_1 USING @var_practiceid,@start_date,@start_date,@start_date;
			 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE revenue_forcast_on_patient_volume(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15))
BEGIN
	SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceid);
	SET @var_practiceid = practiceid;
	
	
	SET @queryText ="SELECT COUNT(DISTINCT account_nbr) into @value1 FROM 
	analytic_data 
	WHERE Date_of_Service> (DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH))
	AND practice_id=? and cptcode in(\'99201\',\'99202\',\'99203\',\'99204\',\'99205\',\'99241\',\'99242\',\'99243\',\'99244\',\'99245\')";
	
	IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @start_date,@start_date,@var_practiceid;
	 DEALLOCATE PREPARE statement_1;
	
	-- Deactive Patient in last year	
	SET @queryText ="SELECT COUNT(DISTINCT previousYearPts.account_nbr) INTO @inactivePts FROM 
	(
	SELECT DISTINCT account_nbr  FROM analytic_data 
	WHERE Date_of_Service>= (DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH))
	AND practice_id=?";
	
	IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	 
	SET @queryText = CONCAT(@queryText,") currentYearPts
	RIGHT JOIN
	(
	SELECT DISTINCT account_nbr FROM analytic_data 
	WHERE Date_of_Service< (DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH))
	AND practice_id=?");
	
	IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	 
	SET @queryText = CONCAT(@queryText,") previousYearPts ON(currentYearPts.account_nbr=previousYearPts.account_nbr)
	WHERE currentYearPts.account_nbr IS NULL");
	
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @start_date,@start_date,@var_practiceid,@start_date,@start_date,@var_practiceid;
	 DEALLOCATE PREPARE statement_1;
	 
	-- INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code)
	SET @queryText ="SELECT @value1-@inactivePts AS avgincreasepatientPercentage,
	COUNT(ad.id)/COUNT(DISTINCT account_nbr)*(@value1-@inactivePts) AS increaseexpectedencounter,
	SUM(ad.Primary_Insurance_Allowance)/COUNT(ad.id) AS avgRevenuPerEncounter,@inactivePts as DeactivePts
	FROM analytic_data ad 
	WHERE ad.practice_id=? AND Date_of_Service> (DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH))";
	
	IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@start_date;
	 DEALLOCATE PREPARE statement_1;
	 
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE primary_secondary_patient_openbalance(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15))
BEGIN
/* use in Account Receiveable Graphh at dashboard
primary_secondary_patient_openbalance */
	SET @var_practiceid = practiceid;
	SET @queryText ="SELECT SUM(CASE WHEN primary_insurance_payment = 0 OR Primary_Contractual_Adjustment = 0 THEN Insurance_Balance ELSE 0 END) AS PrimaryBalance,
		SUM(CASE WHEN (primary_insurance_payment <> 0 OR Primary_Contractual_Adjustment <> 0) AND Secondary_Insurance_Name <> \'null\' AND Secondary_Insurance_Payment=0 
		AND Secondary_Contractual_Adjustment=0 THEN Insurance_Balance ELSE 0 END) AS SecondaryBalance,
		SUM(Patient_Balance) AS PatientBalance
		FROM analytic_data WHERE practice_id=?";
		
		IF serviceLocation <>"" THEN
			SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
		 END IF;
		
		IF providerName <>"" THEN
			SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
		 END IF;
		 
		 IF insuranceCompanyName <>"" THEN
			SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
		 END IF;
		 IF cptCode <>"" THEN
			SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
		 END IF;
		 
		 PREPARE statement_1 FROM @queryText;
		 EXECUTE statement_1 USING @var_practiceid;
		 DEALLOCATE PREPARE statement_1;
END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE patient_list(IN practiceid INT, IN patientType VARCHAR(6))
BEGIN
		
	IF patientType = "all" THEN
		SELECT account_nbr,patient_name,DATE_FORMAT(dateofbirth, "%m/%d/%Y") AS dateofbirth,DATE_FORMAT(MIN(date_of_service), "%m/%d/%Y") firstVisit,DATE_FORMAT(MAX(date_of_service), "%m/%d/%Y") lastVisit,SUM(insurance_balance) insuranceBalance,SUM(patient_balance) patientBalance
		FROM analytic_data ad
		WHERE ad.practice_id=practiceid
		GROUP BY account_nbr,patient_name,dateofbirth;
	ELSEIF patientType = "active" THEN
		SELECT ad.account_nbr,patient_name,DATE_FORMAT(dateofbirth, "%m/%d/%Y") AS dateofbirth,DATE_FORMAT(MIN(date_of_service), "%m/%d/%Y") firstVisit,DATE_FORMAT(MAX(date_of_service), "%m/%d/%Y") lastVisit,SUM(insurance_balance) insuranceBalance,SUM(patient_balance) patientBalance
		FROM analytic_data ad
		WHERE ad.practice_id=practiceid AND Date_of_Service> (SELECT DATE_SUB(MAX(Date_of_Service), INTERVAL 1 YEAR) FROM analytic_data WHERE practice_id=practiceid)
		GROUP BY account_nbr,patient_name,dateofbirth;
	ELSEIF patientType = "new" THEN
		SELECT ad.account_nbr,patient_name,DATE_FORMAT(dateofbirth, "%m/%d/%Y") AS dateofbirth,DATE_FORMAT(MIN(date_of_service), "%m/%d/%Y") firstVisit,DATE_FORMAT(MAX(date_of_service), "%m/%d/%Y") lastVisit,SUM(insurance_balance) insuranceBalance,SUM(patient_balance) patientBalance
		FROM analytic_data ad 
		LEFT JOIN
		(
		SELECT DISTINCT account_nbr FROM analytic_data 
		WHERE Date_of_Service<= (SELECT DATE_SUB(MAX(Date_of_Service), INTERVAL 1 YEAR) FROM analytic_data WHERE practice_id=practiceid)
		AND practice_id=practiceid
		) previousYearPts ON(previousYearPts.account_nbr= ad.account_nbr)
		WHERE previousYearPts.account_nbr IS NULL	
		AND ad.practice_id=practiceid 
		GROUP BY account_nbr,patient_name,dateofbirth;
	ELSEIF patientType = "ckd" THEN
		SELECT ad.account_nbr,patient_name,DATE_FORMAT(dateofbirth, "%m/%d/%Y") AS dateofbirth,DATE_FORMAT(MIN(date_of_service), "%m/%d/%Y") firstVisit,DATE_FORMAT(MAX(date_of_service), "%m/%d/%Y") lastVisit,SUM(insurance_balance) insuranceBalance,SUM(patient_balance) patientBalance
		FROM analytic_data ad 
		
		WHERE  ad.practice_id=practiceid 
		AND (icd_1 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_2 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
		AND icd_3 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_4 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
		AND icd_5 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_6 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
		AND icd_7 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')AND icd_8 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\'))
		GROUP BY account_nbr,patient_name,dateofbirth;	
	ELSEIF patientType = "esrd" THEN
		SELECT ad.account_nbr,patient_name,DATE_FORMAT(dateofbirth, "%m/%d/%Y") AS dateofbirth,DATE_FORMAT(MIN(date_of_service), "%m/%d/%Y") firstVisit,DATE_FORMAT(MAX(date_of_service), "%m/%d/%Y") lastVisit,SUM(insurance_balance) insuranceBalance,SUM(patient_balance) patientBalance
		FROM analytic_data ad 
		WHERE  ad.practice_id=practiceid 
		AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_2 IN (SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
		OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
		OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
		OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')  
		OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\'))
		GROUP BY account_nbr,patient_name,dateofbirth;	
	
	END IF;
	
	
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE open_cases(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), IN cptCode VARCHAR(15), IN monthyear VARCHAR(8))
BEGIN
	SET @var_practiceid = practiceid;
	SET @monthwithyear = monthyear;
	
	SET @queryText ="SELECT account_nbr,Patient_Name,DATE_FORMAT(Date_of_Service, \'%m/%d/%Y\') AS Date_of_Service,Primary_Insurance_Name,cptcode,Billed_Amount,Insurance_Balance FROM analytic_data ad where Primary_Insurance_Payment=0 and Primary_Contractual_Adjustment=0 and practice_id=? and CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),DATE_FORMAT(ad.Date_of_Service, \'%y\'))=?" ;
		
		IF serviceLocation <>"" THEN
			SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
		 END IF;
		
		IF providerName <>"" THEN
			SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
		 END IF;
		 
		 IF insuranceCompanyName <>"" THEN
			SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
		 END IF;
		 IF cptCode <>"" THEN
			SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
		 END IF;
			 
		 PREPARE statement_1 FROM @queryText;
		 EXECUTE statement_1 USING @var_practiceid,@monthwithyear;
		 DEALLOCATE PREPARE statement_1;
    END');

        //working fine

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE nonESRD_patient_count(IN practiceId INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), IN cptCode VARCHAR(15))
BEGIN
	SET @var_practiceid = practiceId;
	SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceId);
    
	SET @queryText ="SELECT COUNT(DISTINCT account_nbr) as nonESRDPts FROM analytic_data WHERE practice_id=? AND (icd_1 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_2 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_3 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_4 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_5 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_6 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_7 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')  AND icd_8 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')) and Date_of_Service>= DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH)";
	
	IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	 
	 PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@start_date;
	 DEALLOCATE PREPARE statement_1;
	
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE new_patients_count(IN practiceId INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), IN cptCode VARCHAR(15))
BEGIN
	SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceId);
	SET @var_practiceid = practiceId;
    
	SET @queryText =\'SELECT COUNT(DISTINCT account_nbr) as newPts FROM \r\n\tanalytic_data \r\n\tWHERE Date_of_Service> (DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH))\r\n\tAND practice_id=? and cptcode in("99201","99202","99203","99204","99205","99241","99242","99243","99244","99245")\';
	
	IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	 
	-- SET @queryText = CONCAT(@queryText,") currentYearPts
	
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @start_date,@start_date,@var_practiceid;
	 DEALLOCATE PREPARE statement_1;
	
/*
	SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceId);
	SET @var_practiceid = practiceId;
    
	SET @queryText =\'SELECT COUNT(DISTINCT currentYearPts.account_nbr) as newPts FROM 
	(
	SELECT DISTINCT account_nbr  FROM analytic_data 
	WHERE Date_of_Service> (DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH))
	AND practice_id=?\';
	
	IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	 
	SET @queryText = CONCAT(@queryText,") currentYearPts
	LEFT JOIN
	(
	SELECT DISTINCT account_nbr FROM analytic_data 
	WHERE Date_of_Service<= (DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH))
	AND practice_id=?");
	
	IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	 
	SET @queryText = CONCAT(@queryText,") previousYearPts ON(currentYearPts.account_nbr=previousYearPts.account_nbr)
	WHERE previousYearPts.account_nbr IS NULL");
	
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @start_date,@start_date,@var_practiceid,@start_date,@start_date,@var_practiceid;
	 DEALLOCATE PREPARE statement_1;
	*/
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE new_patiens_count_output(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), IN cptCode VARCHAR(15))
BEGIN
	
	SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceId);
	SET @var_practiceid = practiceId;
	-- set @totalCount = 0;
	
	SET @queryText ="SELECT COUNT(DISTINCT currentYearPts.account_nbr) INTO @value FROM 
	(
	SELECT DISTINCT account_nbr  FROM analytic_data 
	WHERE Date_of_Service> (DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH))
	AND practice_id=?";
	
	IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	 
	SET @queryText = CONCAT(@queryText,") currentYearPts
	LEFT JOIN
	(
	SELECT DISTINCT account_nbr FROM analytic_data 
	WHERE Date_of_Service<= (DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH))
	AND practice_id=?");
	
	IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	 
	SET @queryText = CONCAT(@queryText,") previousYearPts ON(currentYearPts.account_nbr=previousYearPts.account_nbr)
	WHERE previousYearPts.account_nbr IS NULL");
	
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @start_date,@start_date,@var_practiceid,@start_date,@start_date,@var_practiceid;
	 DEALLOCATE PREPARE statement_1;
	 
    END');
//wqrking fine
        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE monthly_patient_analysis(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15))
BEGIN
	SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceid);
	
	SET @var_practiceid = practiceid;
	SET @queryText ="SELECT DATE_FORMAT(ad.Date_of_Service,\'%b-%y\') AS \'MONTH\',COUNT(DISTINCT account_nbr) as patientCount
		FROM analytic_data ad 
		WHERE practice_id=? AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH) AND ?";
		
			IF serviceLocation <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
			 END IF;
			
			IF providerName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
			 END IF;
			 
			 IF insuranceCompanyName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
			 END IF;
			 IF cptCode <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
			 END IF;
			 
		SET @queryText = CONCAT(@queryText," GROUP BY DATE_FORMAT(ad.Date_of_Service,\'%b-%y\')
					ORDER BY YEAR(ad.Date_of_Service),MONTH(ad.Date_of_Service)");
					
		PREPARE statement_1 FROM @queryText;
		 EXECUTE statement_1 USING @var_practiceid,@start_date,@start_date,@start_date;
		 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE monthly_new_patient_analysis(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), IN cptCode VARCHAR(15))
BEGIN
	
	SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceid);
	SET @var_practiceid = practiceid;
	
	SET @queryText =\'SELECT firstMonth.MONTH,firstMonth.prevMonthPts+secondMonth.newPts as targetPts,secondMonth.newPts AS nextMonth,secondMonth.curMonthPts achievedPts FROM \r\n\t\t(\r\n\t\tSELECT COUNT(DISTINCT account_nbr) AS prevMonthPts,\r\n\t\tDATE_FORMAT(DATE_SUB(@start_date, interval 11 month),"%b-%y") AS "MONTH" \r\n\t\tFROM analytic_data ad\r\n\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 12 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 12 MONTH)\';
		
			IF serviceLocation <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
			 END IF;
			
			IF providerName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
			 END IF;
			 
			 IF insuranceCompanyName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
			 END IF;
			 IF cptCode <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
			 END IF;
			 
		SET @queryText = CONCAT(@queryText,\' ) firstMonth LEFT JOIN\r\n\t\t(\r\n\t\t\tSELECT SUM(CASE WHEN innerfirstMonth.account_nbr IS NULL THEN 1 ELSE 0 END) AS newPts,COUNT(DISTINCT innersecondMonth.account_nbr) AS curMonthPts,\r\n\t\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 11 MONTH),"%b-%y") AS "MONTH"   \r\n\t\t\tFROM \r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 12 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 12 MONTH)\');
			
			IF serviceLocation <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
			 END IF;
			
			IF providerName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
			 END IF;
			 
			 IF insuranceCompanyName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
			 END IF;
			 IF cptCode <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
			 END IF;
			 
			SET @queryText = CONCAT(@queryText,\' ) innerfirstMonth RIGHT JOIN\r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 11 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 11 MONTH)\');
			
			IF serviceLocation <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
			 END IF;
			
			IF providerName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
			 END IF;
			 
			 IF insuranceCompanyName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
			 END IF;
			 IF cptCode <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
			 END IF;
			 
			SET @queryText = CONCAT(@queryText,\' ) innersecondMonth ON(innerfirstMonth.account_nbr = innersecondMonth.account_nbr)\r\n\t\t) secondMonth ON(firstMonth.MONTH = secondMonth.MONTH)\r\n\t\t\r\n\t\tUNION\t\r\n\t\t\r\n\t\tSELECT firstMonth.MONTH,firstMonth.prevMonthPts+secondMonth.newPts as targetPts,secondMonth.newPts AS nextMonth,secondMonth.curMonthPts achievedPts FROM \r\n\t\t(\r\n\t\tSELECT COUNT(DISTINCT account_nbr) AS prevMonthPts,\r\n\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 10 MONTH),"%b-%y") AS "MONTH"\r\n\t\tFROM analytic_data ad\r\n\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 11 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 11 MONTH)\');
			IF serviceLocation <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
			 END IF;
			
			IF providerName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
			 END IF;
			 
			 IF insuranceCompanyName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
			 END IF;
			 IF cptCode <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
			 END IF;
			 
		SET @queryText = CONCAT(@queryText,\') firstMonth LEFT JOIN\r\n\t\t(\r\n\t\t\tSELECT SUM(CASE WHEN innerfirstMonth.account_nbr IS NULL THEN 1 ELSE 0 END) AS newPts,COUNT(DISTINCT innersecondMonth.account_nbr) AS curMonthPts,\r\n\t\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 10 MONTH),"%b-%y") AS "MONTH"\r\n\t\t\tFROM \r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 11 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 11 MONTH)\');
			
			IF serviceLocation <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
			 END IF;
			
			IF providerName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
			 END IF;
			 
			 IF insuranceCompanyName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
			 END IF;
			 IF cptCode <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
			 END IF;
			 
		SET @queryText = CONCAT(@queryText,\') innerfirstMonth RIGHT JOIN\r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 10 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 10 MONTH)\');
			IF serviceLocation <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
			 END IF;
			
			IF providerName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
			 END IF;
			 
			 IF insuranceCompanyName <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
			 END IF;
			 IF cptCode <>"" THEN
			 	SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
			 END IF;
			 
		SET @queryText = CONCAT(@queryText,\') innersecondMonth ON(innerfirstMonth.account_nbr = innersecondMonth.account_nbr)\r\n\t\t) secondMonth ON(firstMonth.MONTH = secondMonth.MONTH)\r\n\t\t\r\n\t\tUNION\t\r\n\t\t\r\n\t\tSELECT firstMonth.MONTH,firstMonth.prevMonthPts+secondMonth.newPts as targetPts,secondMonth.newPts,secondMonth.curMonthPts achievedPts FROM \r\n\t\t(\r\n\t\tSELECT COUNT(DISTINCT account_nbr) AS prevMonthPts,\r\n\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 9 MONTH),"%b-%y") AS "MONTH"\r\n\t\tFROM analytic_data ad\r\n\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 10 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 10 MONTH)\r\n\t\t) firstMonth LEFT JOIN\r\n\t\t(\r\n\t\t\tSELECT SUM(CASE WHEN innerfirstMonth.account_nbr IS NULL THEN 1 ELSE 0 END) AS newPts,COUNT(DISTINCT innersecondMonth.account_nbr) AS curMonthPts,\r\n\t\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 9 MONTH),"%b-%y") AS "MONTH"\r\n\t\t\tFROM \r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 10 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 10 MONTH)\r\n\t\t\t) innerfirstMonth RIGHT JOIN\r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 9 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 9 MONTH)\r\n\t\t\t) innersecondMonth ON(innerfirstMonth.account_nbr = innersecondMonth.account_nbr)\r\n\t\t) secondMonth ON(firstMonth.MONTH = secondMonth.MONTH)\r\n\t\t\r\n\t\tUNION\t\r\n\t\t\r\n\t\tSELECT firstMonth.MONTH,firstMonth.prevMonthPts+secondMonth.newPts as targetPts,secondMonth.newPts,secondMonth.curMonthPts achievedPts FROM \r\n\t\t(\r\n\t\tSELECT COUNT(DISTINCT account_nbr) AS prevMonthPts,\r\n\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 8 MONTH),"%b-%y") AS "MONTH"\r\n\t\tFROM analytic_data ad\r\n\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 9 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 9 MONTH)\r\n\t\t) firstMonth LEFT JOIN\r\n\t\t(\r\n\t\t\tSELECT SUM(CASE WHEN innerfirstMonth.account_nbr IS NULL THEN 1 ELSE 0 END) AS newPts,COUNT(DISTINCT innersecondMonth.account_nbr) AS curMonthPts,\r\n\t\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 8 MONTH),"%b-%y") AS "MONTH"\r\n\t\t\tFROM \r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 9 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 9 MONTH)\r\n\t\t\t) innerfirstMonth RIGHT JOIN\r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 8 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 8 MONTH)\r\n\t\t\t) innersecondMonth ON(innerfirstMonth.account_nbr = innersecondMonth.account_nbr)\r\n\t\t) secondMonth ON(firstMonth.MONTH = secondMonth.MONTH)\r\n\t\t\r\n\t\tUNION\t\r\n\t\t\r\n\t\tSELECT firstMonth.MONTH,firstMonth.prevMonthPts+secondMonth.newPts as targetPts,secondMonth.newPts,secondMonth.curMonthPts achievedPts FROM \r\n\t\t(\r\n\t\tSELECT COUNT(DISTINCT account_nbr) AS prevMonthPts,\r\n\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 7 MONTH),"%b-%y") AS "MONTH"\r\n\t\tFROM analytic_data ad\r\n\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 8 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 8 MONTH)\r\n\t\t) firstMonth LEFT JOIN\r\n\t\t(\r\n\t\t\tSELECT SUM(CASE WHEN innerfirstMonth.account_nbr IS NULL THEN 1 ELSE 0 END) AS newPts,COUNT(DISTINCT innersecondMonth.account_nbr) AS curMonthPts,\r\n\t\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 7 MONTH),"%b-%y") AS "MONTH"\r\n\t\t\tFROM \r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 8 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 8 MONTH)\r\n\t\t\t) innerfirstMonth RIGHT JOIN\r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 7 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 7 MONTH)\r\n\t\t\t) innersecondMonth ON(innerfirstMonth.account_nbr = innersecondMonth.account_nbr)\r\n\t\t) secondMonth ON(firstMonth.MONTH = secondMonth.MONTH)\r\n\t\t\r\n\t\tUNION\t\r\n\t\t\r\n\t\tSELECT firstMonth.MONTH,firstMonth.prevMonthPts+secondMonth.newPts as targetPts,secondMonth.newPts,secondMonth.curMonthPts achievedPts FROM \r\n\t\t(\r\n\t\tSELECT COUNT(DISTINCT account_nbr) AS prevMonthPts,\r\n\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 6 MONTH),"%b-%y") AS "MONTH"\r\n\t\tFROM analytic_data ad\r\n\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 7 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 7 MONTH)\r\n\t\t) firstMonth LEFT JOIN\r\n\t\t(\r\n\t\t\tSELECT SUM(CASE WHEN innerfirstMonth.account_nbr IS NULL THEN 1 ELSE 0 END) AS newPts,COUNT(DISTINCT innersecondMonth.account_nbr) AS curMonthPts,\r\n\t\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 6 MONTH),"%b-%y") AS "MONTH"\r\n\t\t\tFROM \r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 7 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 7 MONTH)\r\n\t\t\t) innerfirstMonth RIGHT JOIN\r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 6 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 6 MONTH)\r\n\t\t\t) innersecondMonth ON(innerfirstMonth.account_nbr = innersecondMonth.account_nbr)\r\n\t\t) secondMonth ON(firstMonth.MONTH = secondMonth.MONTH)\r\n\t\t\r\n\t\tUNION\t\r\n\t\t\r\n\t\tSELECT firstMonth.MONTH,firstMonth.prevMonthPts+secondMonth.newPts as targetPts,secondMonth.newPts,secondMonth.curMonthPts achievedPts FROM \r\n\t\t(\r\n\t\tSELECT COUNT(DISTINCT account_nbr) AS prevMonthPts,\r\n\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 5 MONTH),"%b-%y") AS "MONTH"\r\n\t\tFROM analytic_data ad\r\n\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 6 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 6 MONTH)\r\n\t\t) firstMonth LEFT JOIN\r\n\t\t(\r\n\t\t\tSELECT SUM(CASE WHEN innerfirstMonth.account_nbr IS NULL THEN 1 ELSE 0 END) AS newPts,COUNT(DISTINCT innersecondMonth.account_nbr) AS curMonthPts,\r\n\t\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 5 MONTH),"%b-%y") AS "MONTH"\r\n\t\t\tFROM \r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 6 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 6 MONTH)\r\n\t\t\t) innerfirstMonth RIGHT JOIN\r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 5 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 5 MONTH)\r\n\t\t\t) innersecondMonth ON(innerfirstMonth.account_nbr = innersecondMonth.account_nbr)\r\n\t\t) secondMonth ON(firstMonth.MONTH = secondMonth.MONTH)\r\n\t\t\r\n\t\tUNION\t\r\n\t\t\r\n\t\tSELECT firstMonth.MONTH,firstMonth.prevMonthPts+secondMonth.newPts as targetPts,secondMonth.newPts,secondMonth.curMonthPts achievedPts FROM \r\n\t\t(\r\n\t\tSELECT COUNT(DISTINCT account_nbr) AS prevMonthPts,\r\n\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 4 MONTH),"%b-%y") AS "MONTH"\r\n\t\tFROM analytic_data ad\r\n\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 5 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 5 MONTH)\r\n\t\t) firstMonth LEFT JOIN\r\n\t\t(\r\n\t\t\tSELECT SUM(CASE WHEN innerfirstMonth.account_nbr IS NULL THEN 1 ELSE 0 END) AS newPts,COUNT(DISTINCT innersecondMonth.account_nbr) AS curMonthPts,\r\n\t\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 4 MONTH),"%b-%y") AS "MONTH"\r\n\t\t\tFROM \r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 5 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 5 MONTH)\r\n\t\t\t) innerfirstMonth RIGHT JOIN\r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 4 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 4 MONTH)\r\n\t\t\t) innersecondMonth ON(innerfirstMonth.account_nbr = innersecondMonth.account_nbr)\r\n\t\t) secondMonth ON(firstMonth.MONTH = secondMonth.MONTH)\r\n\t\t\r\n\t\tUNION\t\r\n\t\t\r\n\t\tSELECT firstMonth.MONTH,firstMonth.prevMonthPts+secondMonth.newPts as targetPts,secondMonth.newPts,secondMonth.curMonthPts achievedPts FROM \r\n\t\t(\r\n\t\tSELECT COUNT(DISTINCT account_nbr) AS prevMonthPts,\r\n\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 3 MONTH),"%b-%y") AS "MONTH"\r\n\t\tFROM analytic_data ad\r\n\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 4 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 4 MONTH)\r\n\t\t) firstMonth LEFT JOIN\r\n\t\t(\r\n\t\t\tSELECT SUM(CASE WHEN innerfirstMonth.account_nbr IS NULL THEN 1 ELSE 0 END) AS newPts,COUNT(DISTINCT innersecondMonth.account_nbr) AS curMonthPts,\r\n\t\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 3 MONTH),"%b-%y") AS "MONTH"\r\n\t\t\tFROM \r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 4 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 4 MONTH)\r\n\t\t\t) innerfirstMonth RIGHT JOIN\r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 3 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 3 MONTH)\r\n\t\t\t) innersecondMonth ON(innerfirstMonth.account_nbr = innersecondMonth.account_nbr)\r\n\t\t) secondMonth ON(firstMonth.MONTH = secondMonth.MONTH)\r\n\t\t\r\n\t\tUNION\t\r\n\t\t\r\n\t\tSELECT firstMonth.MONTH,firstMonth.prevMonthPts+secondMonth.newPts as targetPts,secondMonth.newPts,secondMonth.curMonthPts achievedPts FROM \r\n\t\t(\r\n\t\tSELECT COUNT(DISTINCT account_nbr) AS prevMonthPts,\r\n\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 2 MONTH),"%b-%y") AS "MONTH"\r\n\t\tFROM analytic_data ad\r\n\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 3 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 3 MONTH)\r\n\t\t) firstMonth LEFT JOIN\r\n\t\t(\r\n\t\t\tSELECT SUM(CASE WHEN innerfirstMonth.account_nbr IS NULL THEN 1 ELSE 0 END) AS newPts,COUNT(DISTINCT innersecondMonth.account_nbr) AS curMonthPts,\r\n\t\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 2 MONTH),"%b-%y") AS "MONTH"\r\n\t\t\tFROM \r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 3 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 3 MONTH)\r\n\t\t\t) innerfirstMonth RIGHT JOIN\r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 2 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 2 MONTH)\r\n\t\t\t) innersecondMonth ON(innerfirstMonth.account_nbr = innersecondMonth.account_nbr)\r\n\t\t) secondMonth ON(firstMonth.MONTH = secondMonth.MONTH)\r\n\t\t\r\n\t\tUNION\t\r\n\t\t\r\n\t\tSELECT firstMonth.MONTH,firstMonth.prevMonthPts+secondMonth.newPts as targetPts,secondMonth.newPts,secondMonth.curMonthPts achievedPts FROM \r\n\t\t(\r\n\t\tSELECT COUNT(DISTINCT account_nbr) AS prevMonthPts,\r\n\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 1 MONTH),"%b-%y") AS "MONTH"\r\n\t\tFROM analytic_data ad\r\n\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 2 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 2 MONTH)\r\n\t\t) firstMonth LEFT JOIN\r\n\t\t(\r\n\t\t\tSELECT SUM(CASE WHEN innerfirstMonth.account_nbr IS NULL THEN 1 ELSE 0 END) AS newPts,COUNT(DISTINCT innersecondMonth.account_nbr) AS curMonthPts,\r\n\t\t\tDATE_FORMAT(DATE_SUB(@start_date, INTERVAL 1 MONTH),"%b-%y") AS "MONTH"\r\n\t\t\tFROM \r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 2 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 2 MONTH)\r\n\t\t\t) innerfirstMonth RIGHT JOIN\r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 1 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 1 MONTH)\r\n\t\t\t) innersecondMonth ON(innerfirstMonth.account_nbr = innersecondMonth.account_nbr)\r\n\t\t) secondMonth ON(firstMonth.MONTH = secondMonth.MONTH)\r\n\t\t\r\n\t\tUNION\r\n\t\t\r\n\t\tSELECT firstMonth.MONTH,firstMonth.prevMonthPts+secondMonth.newPts AS targetPts,secondMonth.newPts,secondMonth.curMonthPts achievedPts FROM \r\n\t\t(\r\n\t\tSELECT COUNT(DISTINCT account_nbr) AS prevMonthPts,\r\n\t\tDATE_FORMAT(@start_date,"%b-%y") AS "MONTH" \r\n\t\tFROM analytic_data ad\r\n\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 1 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 1 MONTH)\r\n\t\t) firstMonth LEFT JOIN\r\n\t\t(\r\n\t\t\tSELECT SUM(CASE WHEN innerfirstMonth.account_nbr IS NULL THEN 1 ELSE 0 END) AS newPts,COUNT(DISTINCT innersecondMonth.account_nbr) AS curMonthPts,\r\n\t\t\tDATE_FORMAT(@start_date,"%b-%y") AS "MONTH" \r\n\t\t\tFROM \r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY), INTERVAL 1 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 1 MONTH)\r\n\t\t\t) innerfirstMonth RIGHT JOIN\r\n\t\t\t(\r\n\t\t\tSELECT DISTINCT account_nbr FROM analytic_data ad\r\n\t\t\tWHERE ad.practice_id=@var_practiceid AND ad.Date_of_Service BETWEEN DATE_ADD(@start_date,INTERVAL -DAY(@start_date)+1 DAY) AND LAST_DAY(@start_date)\r\n\t\t\t) innersecondMonth ON(innerfirstMonth.account_nbr = innersecondMonth.account_nbr)\r\n\t\t) secondMonth ON(firstMonth.MONTH = secondMonth.MONTH)\');
		
		PREPARE statement_1 FROM @queryText;
		 EXECUTE statement_1 ;
		 DEALLOCATE PREPARE statement_1;
		
		
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE monthly_droped_patient(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15), IN monthyear VARCHAR(8))
BEGIN
	SET @var_practiceid = practiceid;
	SET @monthwithyear =  CONCAT("01-",monthyear);
	SET @start_date = \'\';
	
	SELECT STR_TO_DATE(@monthwithyear, "%d-%b-%y") INTO @start_date;
	
		SET @queryText =" SELECT ad.account_nbr,patient_name,DATE_FORMAT(dateofbirth, \'%m/%d/%Y\') AS dateofbirth,DATE_FORMAT(MIN(date_of_service), \'%m/%d/%Y\') firstVisit,DATE_FORMAT(MAX(date_of_service), \'%m/%d/%Y\') lastVisit,SUM(insurance_balance) insuranceBalance,SUM(patient_balance) patientBalance
			FROM analytic_data ad WHERE account_nbr IN(
			SELECT prevMonth.account_nbr FROM 
			(
			SELECT DISTINCT account_nbr FROM analytic_data ad WHERE practice_id=@var_practiceid AND Date_of_Service BETWEEN @start_date AND LAST_DAY(@start_date)";
			
			IF serviceLocation <>"" THEN
				SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
			 END IF;
			
			IF providerName <>"" THEN
				SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
			 END IF;
			 
			 IF insuranceCompanyName <>"" THEN
				SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
			 END IF;
			 IF cptCode <>"" THEN
				SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
			 END IF;
		 
			SET @queryText = CONCAT(@queryText," ) curMonth RIGHT JOIN 
			(
			SELECT DISTINCT account_nbr FROM analytic_data ad WHERE practice_id=@var_practiceid AND Date_of_Service BETWEEN DATE_SUB(@start_date , INTERVAL 1 MONTH) AND DATE_SUB(LAST_DAY(@start_date), INTERVAL 1 MONTH)");
			
			IF serviceLocation <>"" THEN
				SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
			 END IF;
			
			IF providerName <>"" THEN
				SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
			 END IF;
			 
			 IF insuranceCompanyName <>"" THEN
				SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
			 END IF;
			 IF cptCode <>"" THEN
				SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
			 END IF;
			 
			SET @queryText = CONCAT(@queryText," )
			prevMonth ON(curMonth.account_nbr=prevMonth.account_nbr)
			WHERE curMonth.account_nbr IS NULL
			) GROUP BY account_nbr,patient_name,dateofbirth");
	
	
		 PREPARE statement_1 FROM @queryText;
		 EXECUTE statement_1 ;
		 DEALLOCATE PREPARE statement_1;
		
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE monthly_cpdcode_analysis(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15), IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
	
	-- SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceid);
	
	SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	
	SET @queryText ="SELECT cptcode,SUM(units) AS units FROM analytic_data
		WHERE cptcode IS NOT NULL and practice_id=? AND Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')";
		
		IF serviceLocation <>"" THEN
			SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
		 END IF;
		
		IF providerName <>"" THEN
			SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
		 END IF;
		 
		 IF insuranceCompanyName <>"" THEN
			SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
		 END IF;
		 IF cptCode <>"" THEN
			SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
		 END IF;
	
	SET @queryText = CONCAT(@queryText,"GROUP BY cptcode ORDER BY units DESC LIMIT 0,10");
	
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@end_date;
	 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE monthly_charges_collection_analysis(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15))
BEGIN
	SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceid);
	
	SET @var_practiceid = practiceid;
	
	SET @queryText =" SELECT DATE_FORMAT(Date_of_Service,\'%b-%y\') AS \'MONTH\',sum(Billed_Amount) AS chargeAmount, sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment) AS collectionAmount
		FROM analytic_data ad WHERE practice_id=? AND Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH) AND ?
		GROUP BY DATE_FORMAT(Date_of_Service,\'%b-%y\')
		ORDER BY YEAR(ad.Date_of_Service),MONTH(ad.Date_of_Service)";
		
		PREPARE statement_1 FROM @queryText;
		 EXECUTE statement_1 USING @var_practiceid,@start_date,@start_date,@start_date;
		 DEALLOCATE PREPARE statement_1;

    END');
        //still working fine
        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE fr_transaction_analysis(IN practiceid INT, IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
    
	SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	
	SET @queryText ="SELECT provider,Primary_Insurance_Name,Insurance_Adjustment,SUM(amount) AS amount FROM 
		(
		SELECT provider,Primary_Insurance_Name,\'Insurance Adjustment\' AS Insurance_Adjustment,SUM(Primary_Contractual_Adjustment) AS amount,\'1\' AS orderby
		FROM analytic_data ad WHERE ad.practice_id=?  and Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
		GROUP BY provider,Primary_Insurance_Name 
		UNION
		SELECT provider,Secondary_Insurance_Name,\'Insurance Adjustment\' AS Insurance_Adjustment,SUM(Secondary_Contractual_Adjustment) AS amount,\'1\' AS orderby
		FROM analytic_data ad WHERE ad.practice_id=?  and Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
		GROUP BY provider,Secondary_Insurance_Name 
		UNION
		SELECT provider,Primary_Insurance_Name,\'Insurance Paid\' AS Insurance_Adjustment,SUM(Primary_Insurance_Payment) AS amount,\'2\' AS orderby
		FROM analytic_data ad WHERE ad.practice_id=?  and Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
		GROUP BY provider,Primary_Insurance_Name 
		UNION
		SELECT provider,Secondary_Insurance_Name,\'Insurance Paid\' AS Insurance_Adjustment,SUM(Secondary_Insurance_Payment) AS amount,\'2\' AS orderby
		FROM analytic_data ad WHERE ad.practice_id=?  and Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
		GROUP BY provider,Secondary_Insurance_Name 
		UNION
		SELECT provider,\'\',\'Patient Paid\' AS Insurance_Adjustment,SUM(Patient_Payment) AS amount ,\'3\' AS orderby
		FROM analytic_data ad WHERE ad.practice_id=?  and Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
		GROUP BY provider 
		) finalResult
		GROUP BY provider,Primary_Insurance_Name,Insurance_Adjustment 
		ORDER BY provider,orderby";
		
		PREPARE statement_1 FROM @queryText;
		 EXECUTE statement_1 USING @var_practiceid,@start_date,@end_date,@var_practiceid,@start_date,@end_date,@var_practiceid,@start_date,@end_date,@var_practiceid,@start_date,@end_date,@var_practiceid,@start_date,@end_date;
		 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE fr_Productivity_Analysis(IN practiceid INT, IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
	
	SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	
	SET @queryText ="SELECT provider,Service_Location,SUM(units) AS units,total_RVU AS rvus,SUM(Billed_Amount) AS charges,
			SUM(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment) AS payments,0 AS refunds,
			SUM(Primary_Contractual_Adjustment+Secondary_Contractual_Adjustment) AS adjustment,0 AS transOouIn,
			SUM(Billed_Amount)-SUM(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)-SUM(Primary_Contractual_Adjustment+Secondary_Contractual_Adjustment) as net
			FROM analytic_data WHERE practice_id=? AND Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
			GROUP BY provider,Service_Location";
	
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@end_date;
	 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE fr_procedure_analysis(IN practiceid INT, IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
	SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	SET @queryText ="SELECT provider,cptcode,SUM(units) AS units,work_RVU AS workRVUs,practice_RVU AS pracRVUs,malpractice_RVU AS malpractRVUs,total_RVU AS totalRVUs,SUM(Billed_Amount) AS charges,cptcode_description
			FROM analytic_data ad WHERE ad.practice_id=?  and Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
			GROUP BY provider,cptcode
			ORDER BY provider,cptcode";
		
	 PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@end_date;
	 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE fr_performance_report(IN practiceid INT, IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
	SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	SET @queryText ="SELECT provider,Service_Location,COUNT(id) AS patientVisit,SUM(units) AS Units,SUM(Billed_Amount) AS charges,1 AS workRVU
		FROM analytic_data ad WHERE ad.practice_id=?  and Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
		GROUP BY provider,Service_Location
		ORDER BY provider,Service_Location";
		
	 PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@end_date;
	 DEALLOCATE PREPARE statement_1;
	
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE fr_patient_payments(IN practiceid INT, IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
	SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	
	SET @queryText ="SELECT \'1\' AS claimID,Patient_Name,DATE_FORMAT(Date_of_Service, \'%m/%d/%Y\') as dateofservice,\'1\' AS reference,\'patient paid\' AS category,DATE_FORMAT(Patient_PaymentDate, \'%m/%d/%Y\') as postingDate
	,DATE_FORMAT(Patient_PaymentDate, \'%m/%d/%Y\') as paymentDate,Patient_Payment
		FROM analytic_data ad 
		WHERE ad.practice_id=?  and Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')" ;
		
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@end_date;
	 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE fr_patient_deductibles(IN practiceid INT, IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
    SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	
	SET @queryText ="SELECT Primary_Insurance_Name,Primary_CheckNo_ReferenceNo,DATE_FORMAT(Date_of_Service, \'%m/%d/%Y\') AS dateofservice,Patient_Name,Billed_Amount-Primary_Contractual_Adjustment  as deductibleAmount
		FROM analytic_data ad WHERE Primary_Insurance_Payment=0 AND Primary_Contractual_Adjustment>0 
		and ad.practice_id=?  and Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')" ; 
		
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@end_date;
	 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE fr_cheque_reconciliation_detail(IN practiceid INT, IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
	SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	
	SET @queryText ="select *from
		(SELECT Primary_Insurance_Name AS insurance,Primary_CheckNo_ReferenceNo AS chequeNo,Primary_PaymentDate_CheckDate AS chequeDate
		,Primary_Insurance_Payment chequeAmount,Primary_Insurance_Payment AS postedAmount,\'\' AS Remarks
		FROM analytic_data ad
		WHERE ad.practice_id=?  and Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
		UNION
		SELECT Secondary_Insurance_Name AS insurance,Secondary_CheckNo AS chequeNo,Secondary_PaymentDate AS chequeDate
		,Secondary_Insurance_Payment chequeAmount,Secondary_Insurance_Payment AS postedAmount,\'\' AS Remarks
		FROM analytic_data ad
		WHERE Secondary_Insurance_Name<>\'null\' AND ad.practice_id=?  and Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\'))
		chequeDetail order by chequeNo";
		
		PREPARE statement_1 FROM @queryText;
		 EXECUTE statement_1 USING @var_practiceid,@start_date,@end_date,@var_practiceid,@start_date,@end_date;
		 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE fr_charges_detail(IN practiceid INT, IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
	
	SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	
	SET @queryText ="SELECT  ad.Patient_Name,Date_of_Service,Service_Location,s.serviceName,Rendering_Provider,Primary_Insurance_Name,\'ClaimID\',ad.cptcode,Billed_Amount FROM analytic_data ad\r\n\tINNER JOIN service_code sc ON(sc.cptcode=ad.cptcode)\r\n\tINNER JOIN service s ON(s.id=sc.service_id)\r\n\tWHERE ad.practice_id=?  and Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')";
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@end_date;
	 DEALLOCATE PREPARE statement_1;
	
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE fr_charges_collection_summary(IN practiceid INT, IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
    
	SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	
	SET @queryText ="SELECT provider,SUM(Billed_Amount) AS totalCharges,SUM(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment) AS totalCollection
	,SUM(Primary_Insurance_Payment+Secondary_Insurance_Payment) AS InsuranceCollection,SUM(Patient_Payment) AS patientCollection,
	SUM(Primary_Contractual_Adjustment+Secondary_Contractual_Adjustment) AS Adjustments,SUM(Insurance_Balance+Patient_Balance) AS patientInsuranceAging
	FROM analytic_data ad WHERE ad.practice_id=? and Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
	GROUP BY provider";
	
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@end_date;
	 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE fr_AR_analysis_provider(IN practiceid INT, IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
	SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	
	SET @queryText ="SELECT providerNames.providerName,IFNULL(prevARs.prevAR,0) AS prevAR,SUM(charges) AS charges,SUM(payments) AS payments
			,SUM(refunds) AS refund,SUM(adjustment) AS adjustment,SUM(trans_out) AS trans_out,SUM(trnas_in) AS trnas_in,
			IFNULL(prevARs.prevAR,0)+SUM(charges)-SUM(payments)-SUM(refunds)-SUM(adjustment)-SUM(trans_out)+SUM(trnas_in) AS newAR
			FROM 
			(
			SELECT DISTINCT provider AS providerName FROM analytic_data WHERE practice_id=?  AND Date_of_Service<= STR_TO_DATE(?,\'%m/%d/%Y\')
			) providerNames
			LEFT JOIN
			(
			SELECT provider ,Billed_Amount AS charges,Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment AS payments,
			\'0\' AS refunds,Primary_Contractual_Adjustment+Secondary_Contractual_Adjustment AS adjustment,\'0\' AS trans_out,0 AS trnas_in
			FROM analytic_data WHERE practice_id=? AND Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
			) paymentproviders ON(providerNames.providerName = paymentproviders.provider)
			LEFT JOIN
			(
			SELECT provider,SUM(Insurance_Balance+Patient_Balance) AS prevAR FROM analytic_data 
			WHERE practice_id=? AND Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
			GROUP BY Service_Location
			) prevARs ON(providerNames.providerName = prevARs.provider)
			GROUP BY providerNames.providerName,IFNULL(prevARs.prevAR,0)";
			
			PREPARE statement_1 FROM @queryText;
			 EXECUTE statement_1 USING @var_practiceid,@end_date,@var_practiceid,@start_date,@end_date,@var_practiceid,@start_date,@end_date;
			 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE fr_AR_analysis_location(IN practiceid INT, IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
	SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	
	SET @queryText ="SELECT locationNames.locationName,IFNULL(prevARs.prevAR,0) AS prevAR,SUM(charges) AS charges,SUM(payments) AS payments
			,SUM(refunds) AS refund,SUM(adjustment) AS adjustment,SUM(trans_out) AS trans_out,SUM(trnas_in) AS trnas_in,
			IFNULL(prevARs.prevAR,0)+SUM(charges)-SUM(payments)-SUM(refunds)-SUM(adjustment)-SUM(trans_out)+SUM(trnas_in) AS newAR
			FROM 
			(
			SELECT DISTINCT Service_Location AS locationName FROM analytic_data WHERE practice_id=?  AND Date_of_Service<= STR_TO_DATE(?,\'%m/%d/%Y\')
			) locationNames
			LEFT JOIN
			(
			SELECT Service_Location,Billed_Amount AS charges,Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment AS payments,
			\'0\' AS refunds,Primary_Contractual_Adjustment+Secondary_Contractual_Adjustment AS adjustment,\'0\' AS trans_out,0 AS trnas_in
			FROM analytic_data WHERE practice_id=? AND Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
			) paymentlocations ON(locationNames.locationName = paymentlocations.Service_Location)
			LEFT JOIN
			(
			SELECT Service_Location,SUM(Insurance_Balance) AS prevAR FROM analytic_data 
			WHERE practice_id=? AND Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
			GROUP BY Service_Location
			) prevARs ON(locationNames.locationName = prevARs.Service_Location)
			GROUP BY locationNames.locationName,IFNULL(prevARs.prevAR,0)";
			
			PREPARE statement_1 FROM @queryText;
			 EXECUTE statement_1 USING @var_practiceid,@end_date,@var_practiceid,@start_date,@end_date,@var_practiceid,@start_date,@end_date;
			 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE fr_AR_analysis_insurance(IN practiceid INT, IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
    
    SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	
	SET @queryText ="SELECT insuranceNames.insuranceName,IFNULL(prevARs.prevAR,0) AS prevAR,SUM(charges) AS charges,SUM(payments) AS payments
			,SUM(refunds) AS refund,SUM(adjustment) AS adjustment,SUM(trans_out) AS trans_out,SUM(trnas_in) AS trnas_in,
			IFNULL(prevARs.prevAR,0)+SUM(charges)-SUM(payments)-SUM(refunds)-SUM(adjustment)-SUM(trans_out)+SUM(trnas_in) AS newAR
			FROM 
			(
			SELECT DISTINCT Primary_Insurance_Name AS insuranceName FROM analytic_data WHERE practice_id=?  AND Date_of_Service< STR_TO_DATE(?,\'%m/%d/%Y\')
			UNION 
			SELECT DISTINCT Secondary_Insurance_Name AS insuranceName FROM analytic_data WHERE practice_id=?  AND Date_of_Service< STR_TO_DATE(?,\'%m/%d/%Y\')
			) insuranceNames
			LEFT JOIN
			(
			SELECT Primary_Insurance_Name,Billed_Amount AS charges,Primary_Insurance_Payment AS payments,
			\'0\' AS refunds,Primary_Contractual_Adjustment AS adjustment,\'0\' AS trans_out,0 AS trnas_in
			FROM analytic_data WHERE practice_id=? AND Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
			UNION
			SELECT Secondary_Insurance_Name,0 AS charges,Secondary_Insurance_Payment AS payments,
			\'0\' AS refunds,Secondary_Contractual_Adjustment AS adjustment,\'0\' AS trans_out,0 AS trnas_in
			FROM analytic_data WHERE practice_id=? AND Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
			) primaryInsurances ON(insuranceNames.insuranceName = primaryInsurances.Primary_Insurance_Name)
			LEFT JOIN
			(
			SELECT Primary_Insurance_Name,SUM(Insurance_Balance) AS prevAR FROM analytic_data 
			WHERE practice_id=? AND Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')
			GROUP BY Primary_Insurance_Name
			) prevARs ON(insuranceNames.insuranceName = prevARs.Primary_Insurance_Name)
			GROUP BY insuranceNames.insuranceName"	;
			
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@var_practiceid,@start_date,@var_practiceid,@start_date,@end_date,@var_practiceid,@start_date,@end_date,@var_practiceid,@start_date,@end_date;
	 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE fr_aging_summary(IN practiceid INT, IN from_date VARCHAR(10), IN to_date VARCHAR(10))
BEGIN
    
	SET @var_practiceid = practiceid;
	SET @start_date = from_date;
	SET @end_date = to_date;
	
	SET @queryText ="SELECT (SELECT SUM(Insurance_Balance+Patient_Balance) FROM analytic_data WHERE practice_id=? AND Date_of_Service< STR_TO_DATE(?,\'%m/%d/%Y\')) AS prevAR,SUM(Billed_Amount) AS charges,SUM(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment) AS payments,SUM(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/SUM(Billed_Amount)*100 AS paymentPercentage,\'0\' AS refunds,SUM(Primary_Contractual_Adjustment+Secondary_Contractual_Adjustment) AS adjustment,\'0\' AS trans_out,0 AS trnas_in,(SELECT SUM(Insurance_Balance+Patient_Balance) FROM analytic_data WHERE practice_id=? AND Date_of_Service< STR_TO_DATE(?,\'%m/%d/%Y\'))+SUM(Billed_Amount)-SUM(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)-0-SUM(Primary_Contractual_Adjustment+Secondary_Contractual_Adjustment)-0+0 AS newAR FROM analytic_data WHERE practice_id=? AND Date_of_Service BETWEEN STR_TO_DATE (?,\'%m/%d/%Y\') AND STR_TO_DATE (?,\'%m/%d/%Y\')";
	
		
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@var_practiceid,@start_date,@var_practiceid,@start_date,@end_date;
	 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE ESRD_patients_count(IN practiceId INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), IN cptCode VARCHAR(15))
BEGIN
	SET @var_practiceid = practiceId;
	SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceId);
	
	SET @queryText ="SELECT COUNT(DISTINCT account_nbr) esrdPts FROM analytic_data WHERE practice_id=? AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_2 IN (SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')  OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\'))and Date_of_Service>= DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH)";
	
	IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	 
	 PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@start_date;
	 DEALLOCATE PREPARE statement_1;
	 
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE collectionAndTargetCurrentMonthYear(IN practiceid INT, IN month_year INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15))
BEGIN
	SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceid);
	
	SET @var_practiceid = practiceid;
	
/* Use for Target Graph month_year=0 for month graph otherwise for year graph */
	IF month_year = 0 THEN
	/*
		SELECT SUM(Primary_Insurance_Payment)+SUM(Secondary_Insurance_Payment)+SUM(Patient_Payment)  AS Collection,SUM(Insurance_Balance) AS openBalance,
		SUM(par_amount) AS targetAmount
		FROM analytic_data ad  INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code)
		WHERE Date_of_Service> (SELECT DATE_SUB(MAX(Date_of_Service), INTERVAL 1 MONTH) FROM analytic_data WHERE practice_id=practiceid)
		AND ad.practice_id=practiceid;
	*/
		SET @queryText =\'SELECT SUM(Primary_Insurance_Payment)+SUM(Secondary_Insurance_Payment)+SUM(Patient_Payment)  AS Collection,SUM(Insurance_Balance) AS openBalance,\r\n\t\tSUM(cptcode_amount) AS targetAmount\r\n\t\tFROM analytic_data ad  \r\n\t\tWHERE Date_of_Service>= (SELECT DATE_ADD(?,INTERVAL -DAY(?)+1 DAY))\r\n\t\tAND ad.practice_id=?\';
		
		IF serviceLocation <>"" THEN
			SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
		 END IF;
		
		IF providerName <>"" THEN
			SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
		 END IF;
		 
		 IF insuranceCompanyName <>"" THEN
			SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
		 END IF;
		 IF cptCode <>"" THEN
			SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
		 END IF;
		
		PREPARE statement_1 FROM @queryText;
		 EXECUTE statement_1 USING @start_date,@start_date,@var_practiceid;
		 DEALLOCATE PREPARE statement_1;	 
	ELSE
	/*
		SELECT SUM(Primary_Insurance_Payment)+SUM(Secondary_Insurance_Payment)+SUM(Patient_Payment)  AS Collection,SUM(Insurance_Balance) AS openBalance,
		SUM(par_amount) AS targetAmount
		FROM analytic_data ad  INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code)
		WHERE Date_of_Service > (SELECT DATE_SUB(MAX(Date_of_Service), INTERVAL 1 YEAR) FROM analytic_data WHERE practice_id=practiceid)
		AND ad.practice_id=practiceid;
		*/
		SET @queryText =\'SELECT SUM(Primary_Insurance_Payment)+SUM(Secondary_Insurance_Payment)+SUM(Patient_Payment)  AS Collection,SUM(Insurance_Balance) AS openBalance,\r\n\t\tSUM(cptcode_amount) AS targetAmount\r\n\t\tFROM analytic_data ad  \r\n\t\tWHERE Date_of_Service >= (SELECT DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY),INTERVAL 1 YEAR))\r\n\t\tAND ad.practice_id=?\';
		
		IF serviceLocation <>"" THEN
			SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
		 END IF;
		
		IF providerName <>"" THEN
			SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
		 END IF;
		 
		 IF insuranceCompanyName <>"" THEN
			SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
		 END IF;
		 IF cptCode <>"" THEN
			SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
		 END IF;
		
		PREPARE statement_1 FROM @queryText;
		 EXECUTE statement_1 USING @start_date,@start_date,@var_practiceid;
		 DEALLOCATE PREPARE statement_1;
	END IF;
	
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE collection_payer_wise_old(IN practiceid INT)
BEGIN
SELECT *FROM (
SELECT Primary_Insurance_Name,\'1\' AS typePts,\'Non-CKD\' AS pType,SUM(activePatient) AS activePatient,SUM(noofclaim) AS noofclaim,SUM(claimProcessed) AS claimProcessed,SUM(claimOpen) AS claimOpen,ROUND(SUM(chargeAmountProcessed),2) AS chargeAmountProcessed,
ROUND(SUM(Collection),2) AS Collection,ROUND(SUM(benchmarks),2) AS benchmarks,ROUND(SUM(Collection)-SUM(benchmarks),2) AS varience,ROUND(SUM(Collection)/SUM(benchmarks)*100,2) AS collectionPercentage
,ROUND(SUM(Collection)/SUM(noofclaim),2) AS perUnitAvgCollection ,ROUND(SUM(openBalance),2) AS openBalance FROM 
(
SELECT ad.Primary_Insurance_Name,COUNT(DISTINCT account_nbr) activePatient,COUNT(ad.id) noofclaim,SUM(CASE WHEN Primary_Insurance_Payment>0 THEN 1 ELSE 0 END) claimProcessed,
COUNT(ad.id)-SUM(CASE WHEN Primary_Insurance_Payment>0 THEN 1 ELSE 0 END) claimOpen,SUM(CASE WHEN Primary_Insurance_Payment>0 THEN Billed_Amount ELSE 0 END) AS chargeAmountProcessed,
SUM(Primary_Insurance_Payment)  AS Collection,SUM(par_amount) AS benchmarks,SUM(Insurance_Balance) AS openBalance
FROM analytic_data ad INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code) 
 WHERE  ad.practice_id=practiceid AND (icd_1 NOT IN(SELECT ckdcode FROM ckd_code) AND icd_2 NOT IN(SELECT ckdcode FROM ckd_code) 
AND icd_3 NOT IN(SELECT ckdcode FROM ckd_code)AND  icd_4 NOT IN(SELECT ckdcode FROM ckd_code) 
AND icd_5 NOT IN(SELECT ckdcode FROM ckd_code) AND  icd_6 NOT IN(SELECT ckdcode FROM ckd_code) 
AND icd_7 NOT IN(SELECT ckdcode FROM ckd_code)  AND icd_8 NOT IN(SELECT ckdcode FROM ckd_code))
 -- and Ad.Date_of_Service BETWEEN \'2019-02-01\' AND \'2019-02-28\'
GROUP BY Primary_Insurance_Name
UNION
SELECT ad.Secondary_Insurance_Name,0,0,0,0,0,SUM(Secondary_Insurance_Payment)  AS Collection,SUM(par_amount) AS benchmarks,SUM(Insurance_Balance) AS openBalance
FROM analytic_data ad  INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code)
WHERE  ad.practice_id=practiceid AND Secondary_Insurance_Name<>\'NULL\' 
AND (icd_1 NOT IN(SELECT ckdcode FROM ckd_code) AND icd_2 NOT IN(SELECT ckdcode FROM ckd_code) 
AND icd_3 NOT IN(SELECT ckdcode FROM ckd_code)AND  icd_4 NOT IN(SELECT ckdcode FROM ckd_code) 
AND icd_5 NOT IN(SELECT ckdcode FROM ckd_code) AND  icd_6 NOT IN(SELECT ckdcode FROM ckd_code) 
AND icd_7 NOT IN(SELECT ckdcode FROM ckd_code)  AND icd_8 NOT IN(SELECT ckdcode FROM ckd_code))
-- AND Ad.Date_of_Service BETWEEN \'2019-02-01\' AND \'2019-02-28\' 
GROUP BY Secondary_Insurance_Name
) NonCKD
GROUP BY Primary_Insurance_Name,typePts
UNION
SELECT Primary_Insurance_Name,\'3\' AS typePts,\'ESRD\' AS pType,SUM(activePatient) AS activePatient,SUM(noofclaim) AS noofclaim,SUM(claimProcessed) AS claimProcessed,SUM(claimOpen) AS claimOpen,SUM(chargeAmountProcessed) AS chargeAmountProcessed,
SUM(Collection) AS Collection ,SUM(benchmarks) AS benchmarks,SUM(Collection)-SUM(benchmarks) AS varience,SUM(Collection)/SUM(benchmarks)*100 AS collectionPercentage
,SUM(Collection)/SUM(noofclaim) AS perUnitAvgCollection ,SUM(openBalance) AS openBalance FROM 
(
SELECT ad.Primary_Insurance_Name,COUNT(DISTINCT account_nbr) activePatient,COUNT(ad.id) noofclaim,SUM(CASE WHEN Primary_Insurance_Payment>0 THEN 1 ELSE 0 END) claimProcessed,
COUNT(ad.id)-SUM(CASE WHEN Primary_Insurance_Payment>0 THEN 1 ELSE 0 END) claimOpen,SUM(CASE WHEN Primary_Insurance_Payment>0 THEN Billed_Amount ELSE 0 END) AS chargeAmountProcessed,
SUM(Primary_Insurance_Payment)  AS Collection,SUM(par_amount) AS benchmarks,SUM(Insurance_Balance) AS openBalance
FROM analytic_data ad  INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code)
WHERE ad.practice_id=practiceid AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_2 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
OR icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')  OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\'))
-- AND Ad.Date_of_Service BETWEEN \'2019-02-01\' AND \'2019-02-28\'
GROUP BY Primary_Insurance_Name
UNION
SELECT ad.Secondary_Insurance_Name,0,0,0,0,0,SUM(Secondary_Insurance_Payment)  AS Collection,SUM(par_amount) AS benchmarks,SUM(Insurance_Balance) AS openBalance
FROM analytic_data ad  INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code)
WHERE  ad.practice_id=practiceid AND Secondary_Insurance_Name<>\'NULL\' 
AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_2 IN (SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')  
OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')) -- AND Ad.Date_of_Service BETWEEN \'2019-02-01\' AND \'2019-02-28\' 
GROUP BY Secondary_Insurance_Name
) ESRD
GROUP BY Primary_Insurance_Name,typePts
UNION
SELECT Primary_Insurance_Name,\'2\' AS typePts,\'CKD\' AS pType,SUM(activePatient) AS activePatient,SUM(noofclaim) AS noofclaim,SUM(claimProcessed) AS claimProcessed,SUM(claimOpen) AS claimOpen,SUM(chargeAmountProcessed) AS chargeAmountProcessed,
SUM(Collection) AS Collection ,SUM(benchmarks) AS benchmarks,SUM(Collection)-SUM(benchmarks) AS varience,SUM(Collection)/SUM(benchmarks)*100 AS collectionPercentage
,SUM(Collection)/SUM(noofclaim) AS perUnitAvgCollection ,SUM(openBalance) AS openBalance FROM 
(
SELECT ad.Primary_Insurance_Name,COUNT(DISTINCT account_nbr) activePatient,COUNT(ad.id) noofclaim,SUM(CASE WHEN Primary_Insurance_Payment>0 THEN 1 ELSE 0 END) claimProcessed,
COUNT(ad.id)-SUM(CASE WHEN Primary_Insurance_Payment>0 THEN 1 ELSE 0 END) claimOpen,SUM(CASE WHEN Primary_Insurance_Payment>0 THEN Billed_Amount ELSE 0 END) AS chargeAmountProcessed,
SUM(Primary_Insurance_Payment)  AS Collection,SUM(par_amount) AS benchmarks,SUM(Insurance_Balance) AS openBalance
FROM analytic_data ad  INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code)
WHERE ad.practice_id=practiceid AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_2 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') 
OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') 
OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') 
OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\')  OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\'))
-- AND Ad.Date_of_Service BETWEEN \'2019-02-01\' AND \'2019-02-28\'
GROUP BY Primary_Insurance_Name
UNION
SELECT ad.Secondary_Insurance_Name,0,0,0,0,0,SUM(Secondary_Insurance_Payment)  AS Collection,SUM(par_amount) AS benchmarks,SUM(Insurance_Balance) AS openBalance
FROM analytic_data ad  INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code)
WHERE  ad.practice_id=practiceid AND Secondary_Insurance_Name<>\'NULL\' AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_2 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') 
OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') 
OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') 
OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\')  OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\'))
-- AND Ad.Date_of_Service BETWEEN \'2019-02-01\' AND \'2019-02-28\' 
GROUP BY Secondary_Insurance_Name
) CKD
GROUP BY Primary_Insurance_Name,typePts
) ALLPatients ORDER BY Primary_Insurance_Name,typePts;
    END');
//still working fine

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE collection_payer_wise(IN practiceid INT)
BEGIN
SELECT *FROM (
SELECT Primary_Insurance_Name,\'1\' AS typePts,\'Non-CKD\' AS pType,SUM(activePatient) AS activePatient,SUM(noofclaim) AS noofclaim,SUM(claimProcessed) AS claimProcessed,SUM(claimOpen) AS claimOpen,ROUND(SUM(chargeAmountProcessed),2) AS chargeAmountProcessed,
ROUND(SUM(Collection),2) AS Collection,ROUND(SUM(benchmarks),2) AS benchmarks,ROUND(SUM(Collection)-SUM(benchmarks),2) AS varience,ROUND(SUM(Collection)/SUM(benchmarks)*100,2) AS collectionPercentage
,ROUND(SUM(Collection)/SUM(noofclaim),2) AS perUnitAvgCollection ,ROUND(SUM(openBalance),2) AS openBalance FROM 
(
SELECT ad.Primary_Insurance_Name,COUNT(DISTINCT account_nbr) activePatient,COUNT(ad.id) noofclaim,SUM(CASE WHEN Primary_Insurance_Payment>0 THEN 1 ELSE 0 END) claimProcessed,
COUNT(ad.id)-SUM(CASE WHEN Primary_Insurance_Payment>0 THEN 1 ELSE 0 END) claimOpen,SUM(Billed_Amount) AS chargeAmountProcessed,
SUM(Primary_Insurance_Payment)  AS Collection,SUM(par_amount) AS benchmarks,SUM(Insurance_Balance) AS openBalance
FROM analytic_data ad INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code) 
 WHERE  ad.practice_id=practiceid AND (icd_1 NOT IN(SELECT ckdcode FROM ckd_code) AND icd_2 NOT IN(SELECT ckdcode FROM ckd_code) 
AND icd_3 NOT IN(SELECT ckdcode FROM ckd_code)AND  icd_4 NOT IN(SELECT ckdcode FROM ckd_code) 
AND icd_5 NOT IN(SELECT ckdcode FROM ckd_code) AND  icd_6 NOT IN(SELECT ckdcode FROM ckd_code) 
AND icd_7 NOT IN(SELECT ckdcode FROM ckd_code)  AND icd_8 NOT IN(SELECT ckdcode FROM ckd_code))
 -- and Ad.Date_of_Service BETWEEN \'2019-02-01\' AND \'2019-02-28\'
GROUP BY Primary_Insurance_Name
UNION
SELECT ad.Secondary_Insurance_Name,0,0,0,0,0,SUM(Secondary_Insurance_Payment)  AS Collection,SUM(par_amount) AS benchmarks,SUM(Insurance_Balance) AS openBalance
FROM analytic_data ad  INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code)
WHERE  ad.practice_id=practiceid AND Secondary_Insurance_Name<>\'NULL\' 
AND (icd_1 NOT IN(SELECT ckdcode FROM ckd_code) AND icd_2 NOT IN(SELECT ckdcode FROM ckd_code) 
AND icd_3 NOT IN(SELECT ckdcode FROM ckd_code)AND  icd_4 NOT IN(SELECT ckdcode FROM ckd_code) 
AND icd_5 NOT IN(SELECT ckdcode FROM ckd_code) AND  icd_6 NOT IN(SELECT ckdcode FROM ckd_code) 
AND icd_7 NOT IN(SELECT ckdcode FROM ckd_code)  AND icd_8 NOT IN(SELECT ckdcode FROM ckd_code))
-- AND Ad.Date_of_Service BETWEEN \'2019-02-01\' AND \'2019-02-28\' 
GROUP BY Secondary_Insurance_Name
) NonCKD
GROUP BY Primary_Insurance_Name,typePts
UNION
SELECT Primary_Insurance_Name,\'3\' AS typePts,\'ESRD\' AS pType,SUM(activePatient) AS activePatient,SUM(noofclaim) AS noofclaim,SUM(claimProcessed) AS claimProcessed,SUM(claimOpen) AS claimOpen,SUM(chargeAmountProcessed) AS chargeAmountProcessed,
SUM(Collection) AS Collection ,SUM(benchmarks) AS benchmarks,SUM(Collection)-SUM(benchmarks) AS varience,SUM(Collection)/SUM(benchmarks)*100 AS collectionPercentage
,SUM(Collection)/SUM(noofclaim) AS perUnitAvgCollection ,SUM(openBalance) AS openBalance FROM 
(
SELECT ad.Primary_Insurance_Name,COUNT(DISTINCT account_nbr) activePatient,COUNT(ad.id) noofclaim,SUM(CASE WHEN Primary_Insurance_Payment>0 THEN 1 ELSE 0 END) claimProcessed,
COUNT(ad.id)-SUM(CASE WHEN Primary_Insurance_Payment>0 THEN 1 ELSE 0 END) claimOpen,SUM(Billed_Amount) AS chargeAmountProcessed,
SUM(Primary_Insurance_Payment)  AS Collection,SUM(par_amount) AS benchmarks,SUM(Insurance_Balance) AS openBalance
FROM analytic_data ad  INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code)
WHERE ad.practice_id=practiceid AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_2 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
OR icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')  OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\'))
-- AND Ad.Date_of_Service BETWEEN \'2019-02-01\' AND \'2019-02-28\'
GROUP BY Primary_Insurance_Name
UNION
SELECT ad.Secondary_Insurance_Name,0,0,0,0,0,SUM(Secondary_Insurance_Payment)  AS Collection,SUM(par_amount) AS benchmarks,SUM(Insurance_Balance) AS openBalance
FROM analytic_data ad  INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code)
WHERE  ad.practice_id=practiceid AND Secondary_Insurance_Name<>\'NULL\' 
AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_2 IN (SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')  
OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')) -- AND Ad.Date_of_Service BETWEEN \'2019-02-01\' AND \'2019-02-28\' 
GROUP BY Secondary_Insurance_Name
) ESRD
GROUP BY Primary_Insurance_Name,typePts
UNION
SELECT Primary_Insurance_Name,\'2\' AS typePts,\'CKD\' AS pType,SUM(activePatient) AS activePatient,SUM(noofclaim) AS noofclaim,SUM(claimProcessed) AS claimProcessed,SUM(claimOpen) AS claimOpen,SUM(chargeAmountProcessed) AS chargeAmountProcessed,
SUM(Collection) AS Collection ,SUM(benchmarks) AS benchmarks,SUM(Collection)-SUM(benchmarks) AS varience,SUM(Collection)/SUM(benchmarks)*100 AS collectionPercentage
,SUM(Collection)/SUM(noofclaim) AS perUnitAvgCollection ,SUM(openBalance) AS openBalance FROM 
(
SELECT ad.Primary_Insurance_Name,COUNT(DISTINCT account_nbr) activePatient,COUNT(ad.id) noofclaim,SUM(CASE WHEN Primary_Insurance_Payment>0 THEN 1 ELSE 0 END) claimProcessed,
COUNT(ad.id)-SUM(CASE WHEN Primary_Insurance_Payment>0 THEN 1 ELSE 0 END) claimOpen,SUM(Billed_Amount) AS chargeAmountProcessed,
SUM(Primary_Insurance_Payment)  AS Collection,SUM(par_amount) AS benchmarks,SUM(Insurance_Balance) AS openBalance
FROM analytic_data ad  INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code)
WHERE ad.practice_id=practiceid AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_2 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') 
OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') 
OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') 
OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\')  OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\'))
-- AND Ad.Date_of_Service BETWEEN \'2019-02-01\' AND \'2019-02-28\'
GROUP BY Primary_Insurance_Name
UNION
SELECT ad.Secondary_Insurance_Name,0,0,0,0,0,SUM(Secondary_Insurance_Payment)  AS Collection,SUM(par_amount) AS benchmarks,SUM(Insurance_Balance) AS openBalance
FROM analytic_data ad  INNER JOIN cptcode_prices cp ON(ad.cptcode=cp.cpt_code)
WHERE  ad.practice_id=practiceid AND Secondary_Insurance_Name<>\'NULL\' AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_2 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') 
OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') 
OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') 
OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\')  OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\'))
-- AND Ad.Date_of_Service BETWEEN \'2019-02-01\' AND \'2019-02-28\' 
GROUP BY Secondary_Insurance_Name
) CKD
GROUP BY Primary_Insurance_Name,typePts
) ALLPatients ORDER BY Primary_Insurance_Name,typePts;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE collection_ckd_wise(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15))
BEGIN

SET @var_practiceid = practiceid;
SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceid);
SET @queryText ="SELECT nonesrd.collection AS nonesrdcollection,esrd.collection AS esrdcollection FROM
		(
		SELECT \'1\' AS rn ,IFNULL(SUM(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),0) AS collection FROM analytic_data
		WHERE practice_id=? AND Date_of_Service> (DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH))
		AND (icd_1 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_2 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
		AND icd_3 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_4 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
		AND icd_5 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_6 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
		AND icd_7 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_8 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\'))";
	IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	SET @queryText = CONCAT(@queryText,") AS nonesrd
		INNER JOIN(
		SELECT \'1\' AS rn ,IFNULL(SUM(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),0) AS collection FROM analytic_data
		WHERE practice_id=? AND Date_of_Service> (DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH))
		AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_2 IN (SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
		OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
		OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
		OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
		OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\'))");
	IF serviceLocation <>"" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <>"" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <>"" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <>"" THEN
		SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
	 END IF;
	SET @queryText = CONCAT(@queryText,") AS esrd ON(nonesrd.rn=esrd.rn)");
	
	PREPARE statement_1 FROM @queryText;
	 EXECUTE statement_1 USING @var_practiceid,@start_date,@start_date,@var_practiceid,@start_date,@start_date;
	 DEALLOCATE PREPARE statement_1;
END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE collection_analysis_service_location(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15))
BEGIN
SET @var_practiceid = practiceid; 
SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceid);
SET @queryText ="SELECT allfacilityName.Service_Location
 ,allfacilityName.monthNme1,IFNULL(firstMonth.collection1,0) collection1,IFNULL(firstMonth.NoofPts1,0) NoofPts1,round(firstMonth.avgCollectionPerPts1,2) as  avgCollectionPerPts1
 ,allfacilityName.monthNme2,IFNULL(secondMonth.collection2,0) collection2,IFNULL(secondMonth.NoofPts2,0) NoofPts2,round(secondMonth.avgCollectionPerPts2,2) as  avgCollectionPerPts2
 ,allfacilityName.monthNme3,IFNULL(thirdMonth.collection3,0) collection3,IFNULL(thirdMonth.NoofPts3,0) NoofPts3,round(thirdMonth.avgCollectionPerPts3,2) as  avgCollectionPerPts3
 ,allfacilityName.monthNme4,IFNULL(fourthMonth.collection4,0) collection4,IFNULL(fourthMonth.NoofPts4,0) NoofPts4,round(fourthMonth.avgCollectionPerPts4,2) as  avgCollectionPerPts4
 ,allfacilityName.monthNme5,IFNULL(fifthMonth.collection5,0) collection5,IFNULL(fifthMonth.NoofPts5,0) NoofPts5,round(fifthMonth.avgCollectionPerPts5,2) as  avgCollectionPerPts5
 ,allfacilityName.monthNme6,IFNULL(sixMonth.collection6,0) collection6,IFNULL(sixMonth.NoofPts6,0) NoofPts6,round(sixMonth.avgCollectionPerPts6,2) as  avgCollectionPerPts6
 ,allfacilityName.monthNme7,IFNULL(seventhMonth.collection7,0) collection7,IFNULL(seventhMonth.NoofPts7,0) NoofPts7,round(seventhMonth.avgCollectionPerPts7,2) as  avgCollectionPerPts7
 ,allfacilityName.monthNme8,IFNULL(eightth.collection8,0) collection8,IFNULL(eightth.NoofPts8,0) NoofPts8,round(eightth.avgCollectionPerPts8,2) as  avgCollectionPerPts8
 ,allfacilityName.monthNme9,IFNULL(nineth.collection9,0) collection9,IFNULL(nineth.NoofPts9,0) NoofPts9,round(nineth.avgCollectionPerPts9,2) as  avgCollectionPerPts9
 ,allfacilityName.monthNme10,IFNULL(tenth.collection10,0) collection10,IFNULL(tenth.NoofPts10,0) NoofPts10,round(tenth.avgCollectionPerPts10,2) as  avgCollectionPerPts10
 ,allfacilityName.monthNme11,IFNULL(elventh.collection11,0) collection11,IFNULL(elventh.NoofPts11,0) NoofPts11,round(elventh.avgCollectionPerPts11,2) as  avgCollectionPerPts11
 ,allfacilityName.monthNme12,IFNULL(twelveth.collection12,0) collection12,IFNULL(twelveth.NoofPts12,0) NoofPts12,round(twelveth.avgCollectionPerPts12,2) as  avgCollectionPerPts12,
 \'Average\' as monthNme13,(IFNULL(firstMonth.collection1,0)+IFNULL(secondMonth.collection2,0)+IFNULL(thirdMonth.collection3,0)+IFNULL(fourthMonth.collection4,0)
 +IFNULL(fifthMonth.collection5,0)+IFNULL(sixMonth.collection6,0)+IFNULL(seventhMonth.collection7,0)+IFNULL(eightth.collection8,0)
 +IFNULL(nineth.collection9,0)+IFNULL(tenth.collection10,0)+IFNULL(elventh.collection11,0)+IFNULL(twelveth.collection12,0))/12 as collection13,
 (IFNULL(firstMonth.NoofPts1,0)+IFNULL(secondMonth.NoofPts2,0)+IFNULL(thirdMonth.NoofPts3,0)+IFNULL(fourthMonth.NoofPts4,0)
 +IFNULL(fifthMonth.NoofPts5,0)+IFNULL(sixMonth.NoofPts6,0)+IFNULL(seventhMonth.NoofPts7,0)+IFNULL(eightth.NoofPts8,0)
 +IFNULL(nineth.NoofPts9,0)+IFNULL(tenth.NoofPts10,0)+IFNULL(elventh.NoofPts11,0)+IFNULL(twelveth.NoofPts12,0))/12 as NoofPts13,
 
 ((IFNULL(firstMonth.collection1,0)+IFNULL(secondMonth.collection2,0)+IFNULL(thirdMonth.collection3,0)+IFNULL(fourthMonth.collection4,0)
 +IFNULL(fifthMonth.collection5,0)+IFNULL(sixMonth.collection6,0)+IFNULL(seventhMonth.collection7,0)+IFNULL(eightth.collection8,0)
 +IFNULL(nineth.collection9,0)+IFNULL(tenth.collection10,0)+IFNULL(elventh.collection11,0)+IFNULL(twelveth.collection12,0))
 /12)/
 ((IFNULL(firstMonth.NoofPts1,0)+IFNULL(secondMonth.NoofPts2,0)+IFNULL(thirdMonth.NoofPts3,0)+IFNULL(fourthMonth.NoofPts4,0)
 +IFNULL(fifthMonth.NoofPts5,0)+IFNULL(sixMonth.NoofPts6,0)+IFNULL(seventhMonth.NoofPts7,0)+IFNULL(eightth.NoofPts8,0)
 +IFNULL(nineth.NoofPts9,0)+IFNULL(tenth.NoofPts10,0)+IFNULL(elventh.NoofPts11,0)+IFNULL(twelveth.NoofPts12,0))/12) as avgCollectionPerPts13
 
FROM 
(
SELECT DISTINCT ad.Service_Location, CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH))) AS monthNme1,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 10 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 10 MONTH))) AS monthNme2,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 9 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 9 MONTH))) AS monthNme3,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 8 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 8 MONTH))) AS monthNme4,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 7 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 7 MONTH))) AS monthNme5,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 6 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 6 MONTH))) AS monthNme6,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 5 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 5 MONTH))) AS monthNme7,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 4 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 4 MONTH))) AS monthNme8,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 3 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 3 MONTH))) AS monthNme9,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 2 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 2 MONTH))) AS monthNme10,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 1 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 1 MONTH))) AS monthNme11
,CONCAT_WS(\'-\',DATE_FORMAT(?,\'%b\'),YEAR(?)) AS monthNme12
 FROM analytic_data ad WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH) AND ?";
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
SET @queryText = CONCAT(@queryText,") allfacilityName LEFT JOIN 
(
SELECT 
ad.Service_Location,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection1,
COUNT(ad.id) AS NoofPts1,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.Id) AS avgCollectionPerPts1
 FROM analytic_data ad 
 WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 11 MONTH)");
 IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.Service_Location
) firstMonth ON(allfacilityName.Service_Location = firstMonth.Service_Location)
LEFT JOIN(
SELECT 
ad.Service_Location,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection2,
COUNT(ad.id) AS NoofPts2,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.Id) AS avgCollectionPerPts2
 FROM analytic_data ad 
 WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 10 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 10 MONTH)");
 IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
SET @queryText = CONCAT(@queryText,"
 GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.Service_Location
) secondMonth ON(allfacilityName.Service_Location = secondMonth.Service_Location)
LEFT JOIN(
SELECT 
ad.Service_Location,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection3,
COUNT(ad.id) AS NoofPts3,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.Id) AS avgCollectionPerPts3
 FROM analytic_data ad 
 WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 9 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 9 MONTH)");
 IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.Service_Location
) thirdMonth ON(allfacilityName.Service_Location = thirdMonth.Service_Location)
LEFT JOIN(
SELECT 
ad.Service_Location,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection4,
COUNT(ad.id) AS NoofPts4,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.Id) AS avgCollectionPerPts4
 FROM analytic_data ad 
 WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 8 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 8 MONTH)");
 IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.Service_Location
) fourthMonth ON(allfacilityName.Service_Location = fourthMonth.Service_Location)
LEFT JOIN(
SELECT 
ad.Service_Location,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection5,
COUNT(ad.id) AS NoofPts5,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.Id) AS avgCollectionPerPts5
 FROM analytic_data ad 
 WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 7 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 7 MONTH)");
 IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.Service_Location
) fifthMonth ON(allfacilityName.Service_Location = fifthMonth.Service_Location)
LEFT JOIN(
SELECT 
ad.Service_Location,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection6,
COUNT(ad.id) AS NoofPts6,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.Id) AS avgCollectionPerPts6
 FROM analytic_data ad 
 WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 6 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 6 MONTH)");
 IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.Service_Location
) sixMonth ON(allfacilityName.Service_Location = sixMonth.Service_Location)
LEFT JOIN(
SELECT 
ad.Service_Location,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection7,
COUNT(ad.id) AS NoofPts7,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.Id) AS avgCollectionPerPts7
 FROM analytic_data ad 
 WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 5 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 5 MONTH)");
 IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.Service_Location
) seventhMonth ON(allfacilityName.Service_Location = seventhMonth.Service_Location)
LEFT JOIN(
SELECT 
ad.Service_Location,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection8,
COUNT(ad.id) AS NoofPts8,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.Id) AS avgCollectionPerPts8
 FROM analytic_data ad 
 WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 4 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 4 MONTH)");
 IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.Service_Location
) eightth ON(allfacilityName.Service_Location = eightth.Service_Location)
LEFT JOIN(
SELECT 
ad.Service_Location,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection9,
COUNT(ad.id) AS NoofPts9,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.Id) AS avgCollectionPerPts9
 FROM analytic_data ad 
 WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 3 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 3 MONTH)");
 IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.Service_Location
) nineth ON(allfacilityName.Service_Location = nineth.Service_Location)
LEFT JOIN(
SELECT 
ad.Service_Location,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection10,
COUNT(ad.id) AS NoofPts10,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.Id) AS avgCollectionPerPts10
 FROM analytic_data ad 
 WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 2 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 2 MONTH)");
 IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.Service_Location
) tenth ON(allfacilityName.Service_Location = tenth.Service_Location)
LEFT JOIN(
SELECT 
ad.Service_Location,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection11,
COUNT(ad.id) AS NoofPts11,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.Id) AS avgCollectionPerPts11
 FROM analytic_data ad 
 WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 1 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 1 MONTH)");
 IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.Service_Location
) elventh ON(allfacilityName.Service_Location = elventh.Service_Location)
LEFT JOIN(
SELECT 
ad.Service_Location,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection12,
COUNT(ad.id) AS NoofPts12,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.Id) AS avgCollectionPerPts12
 FROM analytic_data ad 
 WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_ADD(?,INTERVAL -DAY(?)+1 DAY) AND LAST_DAY(?)");
 IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.Service_Location
) twelveth ON(allfacilityName.Service_Location = twelveth.Service_Location)");
 -- select @queryText;
	  PREPARE statement_1 FROM @queryText;
	  EXECUTE statement_1 USING @start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,
	  @start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,
	  @start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,
	  @start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,
	  @start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,
	  @var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date
	  ,@var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date
	  ,@var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date
	  ,@var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date
	  ,@var_practiceid,@start_date,@start_date,@start_date;
	  DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE collection_analysis_provider(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15))
BEGIN
SET @var_practiceid = practiceid;
SET @start_date = (SELECT MAX(Date_of_Service) FROM analytic_data WHERE practice_id=practiceid);
SET @queryText ="SELECT allProviders.provider
 ,allProviders.monthNme1,firstMonth.collection1,firstMonth.NoofPts1,round(firstMonth.avgCollectionPerPts1,2) as avgCollectionPerPts1
 ,allProviders.monthNme2,secondMonth.collection2,secondMonth.NoofPts2,round(secondMonth.avgCollectionPerPts2,2) as avgCollectionPerPts2
 ,allProviders.monthNme3,thirdMonth.collection3,thirdMonth.NoofPts3,round(thirdMonth.avgCollectionPerPts3,2) as avgCollectionPerPts3
 ,allProviders.monthNme4,fourthMonth.collection4,fourthMonth.NoofPts4,round(fourthMonth.avgCollectionPerPts4,2) as avgCollectionPerPts4
 ,allProviders.monthNme5,fifthMonth.collection5,fifthMonth.NoofPts5,round(fifthMonth.avgCollectionPerPts5,2) as avgCollectionPerPts5
 ,allProviders.monthNme6,sixMonth.collection6,sixMonth.NoofPts6,round(sixMonth.avgCollectionPerPts6,2) as avgCollectionPerPts6
 ,allProviders.monthNme7,seventhMonth.collection7,seventhMonth.NoofPts7,round(seventhMonth.avgCollectionPerPts7,2) as avgCollectionPerPts7
 ,allProviders.monthNme8,eightth.collection8,eightth.NoofPts8,round(eightth.avgCollectionPerPts8,2) as avgCollectionPerPts8
 ,allProviders.monthNme9,nineth.collection9,nineth.NoofPts9,round(nineth.avgCollectionPerPts9,2) as avgCollectionPerPts9
 ,allProviders.monthNme10,tenth.collection10,tenth.NoofPts10,round(tenth.avgCollectionPerPts10,2) as avgCollectionPerPts10
 ,allProviders.monthNme11,elventh.collection11,elventh.NoofPts11,round(elventh.avgCollectionPerPts11,2) as avgCollectionPerPts11
 ,allProviders.monthNme12,twelveth.collection12,twelveth.NoofPts12,round(twelveth.avgCollectionPerPts12,2) as avgCollectionPerPts12,
 
 \'Average\' as monthNme13,(IFNULL(firstMonth.collection1,0)+IFNULL(secondMonth.collection2,0)+IFNULL(thirdMonth.collection3,0)+IFNULL(fourthMonth.collection4,0)
  +IFNULL(fifthMonth.collection5,0)+IFNULL(sixMonth.collection6,0)+IFNULL(seventhMonth.collection7,0)+IFNULL(eightth.collection8,0)
 +IFNULL(nineth.collection9,0)+IFNULL(tenth.collection10,0)+IFNULL(elventh.collection11,0)+IFNULL(twelveth.collection12,0))/12 as collection13,
 (IFNULL(firstMonth.NoofPts1,0)+IFNULL(secondMonth.NoofPts2,0)+IFNULL(thirdMonth.NoofPts3,0)+IFNULL(fourthMonth.NoofPts4,0)
 +IFNULL(fifthMonth.NoofPts5,0)+IFNULL(sixMonth.NoofPts6,0)+IFNULL(seventhMonth.NoofPts7,0)+IFNULL(eightth.NoofPts8,0)
 +IFNULL(nineth.NoofPts9,0)+IFNULL(tenth.NoofPts10,0)+IFNULL(elventh.NoofPts11,0)+IFNULL(twelveth.NoofPts12,0))/12 as NoofPts13,
 
 ((IFNULL(firstMonth.collection1,0)+IFNULL(secondMonth.collection2,0)+IFNULL(thirdMonth.collection3,0)+IFNULL(fourthMonth.collection4,0)
 +IFNULL(fifthMonth.collection5,0)+IFNULL(sixMonth.collection6,0)+IFNULL(seventhMonth.collection7,0)+IFNULL(eightth.collection8,0)
 +IFNULL(nineth.collection9,0)+IFNULL(tenth.collection10,0)+IFNULL(elventh.collection11,0)+IFNULL(twelveth.collection12,0))
 /12)/
 ((IFNULL(firstMonth.NoofPts1,0)+IFNULL(secondMonth.NoofPts2,0)+IFNULL(thirdMonth.NoofPts3,0)+IFNULL(fourthMonth.NoofPts4,0)
 +IFNULL(fifthMonth.NoofPts5,0)+IFNULL(sixMonth.NoofPts6,0)+IFNULL(seventhMonth.NoofPts7,0)+IFNULL(eightth.NoofPts8,0)
 +IFNULL(nineth.NoofPts9,0)+IFNULL(tenth.NoofPts10,0)+IFNULL(elventh.NoofPts11,0)+IFNULL(twelveth.NoofPts12,0))/12) as avgCollectionPerPts13
 
FROM 
(
SELECT DISTINCT ad.provider, CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH))) AS monthNme1,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 10 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 10 MONTH))) AS monthNme2,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 9 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 9 MONTH))) AS monthNme3,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 8 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 8 MONTH))) AS monthNme4,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 7 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 7 MONTH))) AS monthNme5,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 6 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 6 MONTH))) AS monthNme6,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 5 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 5 MONTH))) AS monthNme7,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 4 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 4 MONTH))) AS monthNme8,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 3 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 3 MONTH))) AS monthNme9,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 2 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 2 MONTH))) AS monthNme10,
CONCAT_WS(\'-\',DATE_FORMAT(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 1 MONTH),\'%b\'),YEAR(DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 1 MONTH))) AS monthNme11
,CONCAT_WS(\'-\',DATE_FORMAT(?,\'%b\'),YEAR(?)) AS monthNme12
FROM analytic_data ad
WHERE ad.practice_id=? and Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH) AND ?";
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
	 
SET @queryText = CONCAT(@queryText," ) allProviders LEFT JOIN 
(
SELECT 
ad.provider,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection1,
COUNT(ad.id) AS NoofPts1,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.id) AS avgCollectionPerPts1
 FROM analytic_data ad 
 WHERE ad.practice_id=? and ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 11 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 11 MONTH)");
 
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
 SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.provider
) firstMonth ON(allProviders.provider = firstMonth.provider)
LEFT JOIN(
SELECT 
ad.provider,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection2,
COUNT(ad.id) AS NoofPts2,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.id) AS avgCollectionPerPts2
 FROM analytic_data ad 
 WHERE ad.practice_id=? and ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 10 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 10 MONTH)");
	
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
 SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.provider
) secondMonth ON(allProviders.provider = secondMonth.provider)
LEFT JOIN(
SELECT 
ad.provider,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection3,
COUNT(ad.id) AS NoofPts3,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.id) AS avgCollectionPerPts3
 FROM analytic_data ad 
 WHERE ad.practice_id=? and ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 9 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 9 MONTH)");
 
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF;
	 	
 SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.provider
) thirdMonth ON(allProviders.provider = thirdMonth.provider)
LEFT JOIN(
SELECT 
ad.provider,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection4,
COUNT(ad.id) AS NoofPts4,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.id) AS avgCollectionPerPts4
 FROM analytic_data ad 
 WHERE ad.practice_id=? and ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 8 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 8 MONTH)");
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF; 
	 
 SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.provider
) fourthMonth ON(allProviders.provider = fourthMonth.provider)
LEFT JOIN(
SELECT 
ad.provider,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection5,
COUNT(ad.id) AS NoofPts5,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.id) AS avgCollectionPerPts5
 FROM analytic_data ad 
 WHERE ad.practice_id=? and ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 7 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 7 MONTH)");
 
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF; 
	 
 SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.provider
) fifthMonth ON(allProviders.provider = fifthMonth.provider)
LEFT JOIN(
SELECT 
ad.provider,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection6,
COUNT(ad.id) AS NoofPts6,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.id) AS avgCollectionPerPts6
 FROM analytic_data ad 
 WHERE ad.practice_id=? and ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 6 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 6 MONTH)");
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF; 
	  
 SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.provider
) sixMonth ON(allProviders.provider = sixMonth.provider)
LEFT JOIN(
SELECT 
ad.provider,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection7,
COUNT(ad.id) AS NoofPts7,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.id) AS avgCollectionPerPts7
 FROM analytic_data ad 
 WHERE ad.practice_id=? and ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 5 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 5 MONTH)");
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF; 
	  
 SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.provider
) seventhMonth ON(allProviders.provider = seventhMonth.provider)
LEFT JOIN(
SELECT 
ad.provider,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection8,
COUNT(ad.id) AS NoofPts8,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.id) AS avgCollectionPerPts8
 FROM analytic_data ad 
 WHERE ad.practice_id=? and ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 4 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 4 MONTH)");
 
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF; 
	 
 SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.provider
) eightth ON(allProviders.provider = eightth.provider)
LEFT JOIN(
SELECT 
ad.provider,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection9,
COUNT(ad.id) AS NoofPts9,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.id) AS avgCollectionPerPts9
 FROM analytic_data ad 
 WHERE ad.practice_id=? and ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 3 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 3 MONTH)");
 
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF; 
	 
 SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.provider
) nineth ON(allProviders.provider = nineth.provider)
LEFT JOIN(
SELECT 
ad.provider,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection10,
COUNT(ad.id) AS NoofPts10,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.id) AS avgCollectionPerPts10
 FROM analytic_data ad 
 WHERE ad.practice_id=? and ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 2 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 2 MONTH)");
 
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF; 
	 
 SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.provider
) tenth ON(allProviders.provider = tenth.provider)
LEFT JOIN(
SELECT 
ad.provider,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection11,
COUNT(ad.id) AS NoofPts11,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.id) AS avgCollectionPerPts11
 FROM analytic_data ad 
 WHERE ad.practice_id=? and ad.Date_of_Service BETWEEN DATE_SUB(DATE_ADD(?,INTERVAL -DAY(?)+1 DAY), INTERVAL 1 MONTH) AND DATE_SUB(LAST_DAY(?), INTERVAL 1 MONTH)");
 
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF; 
	 
 SET @queryText = CONCAT(@queryText," GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.provider
) elventh ON(allProviders.provider = elventh.provider)
LEFT JOIN(
SELECT 
ad.provider,SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment) AS collection12,
COUNT(ad.id) AS NoofPts12,(SUM(Primary_Insurance_Payment)  + SUM(Secondary_Insurance_Payment)+ SUM(Patient_Payment))/COUNT(ad.id) AS avgCollectionPerPts12
 FROM analytic_data ad 
 WHERE ad.practice_id=? and ad.Date_of_Service BETWEEN DATE_ADD(?,INTERVAL -DAY(?)+1 DAY) AND LAST_DAY(?)");
 
	IF serviceLocation <> "" THEN
		SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
	 END IF;
	
	IF providerName <> "" THEN
		SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
	 END IF;
	 
	 IF insuranceCompanyName <> "" THEN
		SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
	 END IF;
	 IF cptCode <> "" THEN
		SET @queryText = CONCAT(@queryText," and ad.cptcode=\'", cptCode,"\'");
	 END IF; 
	 
	 SET @queryText = CONCAT(@queryText,"  GROUP BY CONCAT_WS(\'-\',DATE_FORMAT(ad.Date_of_Service,\'%b\'),YEAR(ad.Date_of_Service)),ad.provider
) twelveth ON(allProviders.provider = twelveth.provider)");
	 -- select @queryText;
	  PREPARE statement_1 FROM @queryText;
	  EXECUTE statement_1 USING @start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,
	  @start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,
	  @start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,
	  @start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,
	  @start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,@start_date,
	  @var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date,
	  @var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date,
	  @var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date,
	  @var_practiceid,@start_date,@start_date,@start_date,@var_practiceid,@start_date,@start_date,@start_date;
	  DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE collectable_openbalance_CKD_wise(IN practiceid INT, IN serviceLocation VARCHAR(300), IN providerName VARCHAR(300), IN insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15))
BEGIN

SET @var_practiceid = practiceid;

	SET @queryText ="SELECT \'NonESRD\' AS NonESRD,SUM(Primary_Insurance_Payment)+SUM(Secondary_Insurance_Payment)+SUM(Patient_Payment)  AS Collection,SUM(Insurance_Balance+Patient_Balance) AS openBalance
		,SUM(case when ad.Primary_Insurance_Payment=0 and Primary_Contractual_Adjustment=0 then cptcode_amount else Insurance_Balance+Patient_Balance end ) AS collectable
		FROM analytic_data ad  
		 WHERE  ad.practice_id= ?   
		 AND (icd_1 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_2 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
		AND icd_3 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')AND  icd_4 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
		AND icd_5 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND  icd_6 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
		AND icd_7 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')  AND icd_8 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\'))";
		
		IF serviceLocation <>"" THEN
			SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
		 END IF;
		
		IF providerName <>"" THEN
			SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
		 END IF;
		 
		 IF insuranceCompanyName <>"" THEN
			SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
		 END IF;
		 IF cptCode <>"" THEN
			SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
		 END IF;
			 
		SET @queryText = CONCAT(@queryText," UNION
		SELECT \'ESRD\' AS NonCKD,SUM(Primary_Insurance_Payment)+SUM(Secondary_Insurance_Payment)+SUM(Patient_Payment)  AS Collection,SUM(Insurance_Balance+Patient_Balance) AS openBalance
		,SUM(case when ad.Primary_Insurance_Payment=0 and Primary_Contractual_Adjustment=0 then cptcode_amount else Insurance_Balance+Patient_Balance end) AS collectable
		FROM analytic_data ad  
		 WHERE  ad.practice_id= ?  AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_2 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') 
		OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
		OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
		OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')  OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\'))");
		
		IF serviceLocation <>"" THEN
			SET @queryText = CONCAT(@queryText," and Service_Location=\'", serviceLocation,"\'");
		 END IF;
		
		IF providerName <>"" THEN
			SET @queryText = CONCAT(@queryText," and provider=\'", providerName,"\'");
		 END IF;
		 
		 IF insuranceCompanyName <>"" THEN
			SET @queryText = CONCAT(@queryText," and Primary_Insurance_Name=\'", insuranceCompanyName,"\'");
		 END IF;
		 IF cptCode <>"" THEN
			SET @queryText = CONCAT(@queryText," and cptcode=\'", cptCode,"\'");
		 END IF;
		 
		 PREPARE statement_1 FROM @queryText;
		 EXECUTE statement_1 USING @var_practiceid,@var_practiceid;
		 DEALLOCATE PREPARE statement_1;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost PROCEDURE aging_summary(IN practiceid INT)
BEGIN
SELECT \'Primary_Insurance\',\'Non-ESRD\' AS dtype,SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)<31 THEN billed_amount ELSE 0 END) AS "zero_thirty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>30 AND DATEDIFF(NOW(),date_of_service) < 61 THEN billed_amount ELSE 0 END) AS "thirty_one_sixty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>60 AND DATEDIFF(NOW(),date_of_service) < 91 THEN billed_amount ELSE 0 END) AS "sixty_one_ninty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>90 AND DATEDIFF(NOW(),date_of_service) < 121 THEN billed_amount ELSE 0 END) AS "ninty_one_twenty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>120 AND DATEDIFF(NOW(),date_of_service) < 181 THEN billed_amount ELSE 0 END) AS "one_twenty_one_one_eighty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>180 THEN billed_amount ELSE 0 END) AS "one_eighty_days",
SUM(billed_amount) AS totalAmolunt
FROM analytic_data ad
WHERE ad.practice_id=practiceid AND icd_1 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_2 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_3 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND
icd_4 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_5 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_6 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
AND icd_7 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_8 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
AND primary_insurance_payment = 0 AND Primary_Contractual_Adjustment =0
/*
UNION
SELECT \'Primary_Insurance\',\'CKD\' AS dtype,SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)<31 THEN billed_amount ELSE 0 END) AS "zero_thirty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>30 AND DATEDIFF(NOW(),date_of_service) < 61 THEN billed_amount ELSE 0 END) AS "thirty_one_sixty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>60 AND DATEDIFF(NOW(),date_of_service) < 91 THEN billed_amount ELSE 0 END) AS "sixty_one_ninty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>90 AND DATEDIFF(NOW(),date_of_service) < 121 THEN billed_amount ELSE 0 END) AS "ninty_one_twenty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>120 AND DATEDIFF(NOW(),date_of_service) < 181 THEN billed_amount ELSE 0 END) AS "one_twenty_one_one_eighty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>180 THEN billed_amount ELSE 0 END) AS "one_eighty_days",
SUM(billed_amount) AS totalAmolunt
FROM analytic_data ad
WHERE ad.practice_id=practiceid AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_2 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR
icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\')
OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\'))
AND primary_insurance_payment = 0 AND Primary_Contractual_Adjustment =0
*/
UNION
SELECT \'Primary_Insurance\',\'ESRD\' AS dtype,SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)<31 THEN billed_amount ELSE 0 END) AS "zero_thirty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>30 AND DATEDIFF(NOW(),date_of_service) < 61 THEN billed_amount ELSE 0 END) AS "thirty_one_sixty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>60 AND DATEDIFF(NOW(),date_of_service) < 91 THEN billed_amount ELSE 0 END) AS "sixty_one_ninty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>90 AND DATEDIFF(NOW(),date_of_service) < 121 THEN billed_amount ELSE 0 END) AS "ninty_one_twenty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>120 AND DATEDIFF(NOW(),date_of_service) < 181 THEN billed_amount ELSE 0 END) AS "one_twenty_one_one_eighty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>180 THEN billed_amount ELSE 0 END) AS "one_eighty_days",
SUM(billed_amount) AS totalAmolunt
FROM analytic_data ad
WHERE ad.practice_id=practiceid AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_2 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR
icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\'))
AND primary_insurance_payment = 0 AND Primary_Contractual_Adjustment =0
UNION
SELECT \'Secondary_Insurance\',\'Non-ESRD\' AS dtype,SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)<31 THEN billed_amount ELSE 0 END) AS "zero_thirty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>30 AND DATEDIFF(NOW(),date_of_service) < 61 THEN billed_amount ELSE 0 END) AS "thirty_one_sixty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>60 AND DATEDIFF(NOW(),date_of_service) < 91 THEN billed_amount ELSE 0 END) AS "sixty_one_ninty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>90 AND DATEDIFF(NOW(),date_of_service) < 121 THEN billed_amount ELSE 0 END) AS "ninty_one_twenty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>120 AND DATEDIFF(NOW(),date_of_service) < 181 THEN billed_amount ELSE 0 END) AS "one_twenty_one_one_eighty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>180 THEN billed_amount ELSE 0 END) AS "one_eighty_days",
SUM(billed_amount) AS totalAmolunt
FROM analytic_data ad
WHERE ad.practice_id=practiceid AND icd_1 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_2 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_3 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND
icd_4 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_5 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_6 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
AND icd_7 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_8 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
AND (primary_insurance_payment <> 0 OR Primary_Contractual_Adjustment <> 0) AND Secondary_Insurance_Name <> \'null\' AND Secondary_Insurance_Payment=0 AND Secondary_Contractual_Adjustment=0
/*
UNION
SELECT \'Secondary_Insurance\',\'CKD\' AS dtype,SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)<31 THEN billed_amount ELSE 0 END) AS "zero_thirty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>30 AND DATEDIFF(NOW(),date_of_service) < 61 THEN billed_amount ELSE 0 END) AS "31_60days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>60 AND DATEDIFF(NOW(),date_of_service) < 91 THEN billed_amount ELSE 0 END) AS "61_90days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>90 AND DATEDIFF(NOW(),date_of_service) < 121 THEN billed_amount ELSE 0 END) AS "90_120days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>120 AND DATEDIFF(NOW(),date_of_service) < 181 THEN billed_amount ELSE 0 END) AS "121_180days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>180 THEN billed_amount ELSE 0 END) AS "one_eighty_days",
SUM(billed_amount) AS totalAmolunt
FROM analytic_data ad
WHERE ad.practice_id=practiceid AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_2 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR
icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\')
OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\'))
AND (primary_insurance_payment <> 0 OR Primary_Contractual_Adjustment <> 0) AND Secondary_Insurance_Name <> \'null\' AND Secondary_Insurance_Payment=0 AND Secondary_Contractual_Adjustment=0
*/
UNION
SELECT \'Secondary_Insurance\',\'ESRD\' AS dtype,SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)<31 THEN billed_amount ELSE 0 END) AS "zero_thirty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>30 AND DATEDIFF(NOW(),date_of_service) < 61 THEN billed_amount ELSE 0 END) AS "31_60days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>60 AND DATEDIFF(NOW(),date_of_service) < 91 THEN billed_amount ELSE 0 END) AS "61_90days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>90 AND DATEDIFF(NOW(),date_of_service) < 121 THEN billed_amount ELSE 0 END) AS "90_120days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>120 AND DATEDIFF(NOW(),date_of_service) < 181 THEN billed_amount ELSE 0 END) AS "121_180days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>180 THEN billed_amount ELSE 0 END) AS "one_eighty_days",
SUM(billed_amount) AS totalAmolunt
FROM analytic_data ad
WHERE ad.practice_id=practiceid AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_2 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR
icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\'))
AND (primary_insurance_payment <> 0 OR Primary_Contractual_Adjustment <> 0) AND Secondary_Insurance_Name <> \'null\' AND Secondary_Insurance_Payment=0 AND Secondary_Contractual_Adjustment=0
UNION
SELECT \'Patient_Balance\',\'Non-ESRD\' AS dtype,SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)<31 THEN Patient_Balance ELSE 0 END) AS "zero_thirty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>30 AND DATEDIFF(NOW(),date_of_service) < 61 THEN Patient_Balance ELSE 0 END) AS "31_60days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>60 AND DATEDIFF(NOW(),date_of_service) < 91 THEN Patient_Balance ELSE 0 END) AS "61_90days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>90 AND DATEDIFF(NOW(),date_of_service) < 121 THEN Patient_Balance ELSE 0 END) AS "90_120days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>120 AND DATEDIFF(NOW(),date_of_service) < 181 THEN Patient_Balance ELSE 0 END) AS "121_180days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>180 THEN Patient_Balance ELSE 0 END) AS "one_eighty_days",
SUM(Patient_Balance) AS totalAmolunt
FROM analytic_data ad
WHERE ad.practice_id=practiceid AND icd_1 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_2 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_3 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND
icd_4 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_5 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_6 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
AND icd_7 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_8 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
/*
UNION
SELECT \'Patient_Balance\',\'CKD\' AS dtype,SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)<31 THEN Patient_Balance ELSE 0 END) AS "zero_thirty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>30 AND DATEDIFF(NOW(),date_of_service) < 61 THEN Patient_Balance ELSE 0 END) AS "31_60days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>60 AND DATEDIFF(NOW(),date_of_service) < 91 THEN Patient_Balance ELSE 0 END) AS "61_90days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>90 AND DATEDIFF(NOW(),date_of_service) < 121 THEN Patient_Balance ELSE 0 END) AS "90_120days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>120 AND DATEDIFF(NOW(),date_of_service) < 181 THEN Patient_Balance ELSE 0 END) AS "121_180days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>180 THEN Patient_Balance ELSE 0 END) AS "one_eighty_days",
SUM(Patient_Balance) AS totalAmolunt
FROM analytic_data ad
WHERE ad.practice_id=practiceid AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_2 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR
icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\')
OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\') OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'CKD\'))
*/
UNION
SELECT \'Patient_Balance\',\'ESRD\' AS dtype,SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)<31 THEN Patient_Balance ELSE 0 END) AS "zero_thirty_days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>30 AND DATEDIFF(NOW(),date_of_service) < 61 THEN Patient_Balance ELSE 0 END) AS "31_60days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>60 AND DATEDIFF(NOW(),date_of_service) < 91 THEN Patient_Balance ELSE 0 END) AS "61_90days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>90 AND DATEDIFF(NOW(),date_of_service) < 121 THEN Patient_Balance ELSE 0 END) AS "90_120days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>120 AND DATEDIFF(NOW(),date_of_service) < 181 THEN Patient_Balance ELSE 0 END) AS "121_180days",
SUM(CASE WHEN DATEDIFF(NOW(),date_of_service)>180 THEN Patient_Balance ELSE 0 END) AS "one_eighty_days",
SUM(Patient_Balance) AS totalAmolunt
FROM analytic_data ad
WHERE ad.practice_id=practiceid AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_2 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR
icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')
OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\'));
END');


        DB::unprepared('CREATE DEFINER=root@localhost FUNCTION func_activePatients(practiceId INT) RETURNS INT(11)
    READS SQL DATA
    DETERMINISTIC
BEGIN
    DECLARE activePts INT;
    
    SELECT COUNT(DISTINCT account_nbr) INTO activePts FROM analytic_data 
	WHERE Date_of_Service> (SELECT DATE_SUB(MAX(Date_of_Service), INTERVAL 1 YEAR) FROM analytic_data WHERE practice_id=practiceId)
	AND practice_id=practiceId;
RETURN activePts;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost FUNCTION func_activePatients1(practiceId INT, serviceLocation VARCHAR(300), providerName VARCHAR(300), insuranceCompanyName VARCHAR(300), cptCode VARCHAR(15)) RETURNS INT(11)
    READS SQL DATA
    DETERMINISTIC
BEGIN
    DECLARE activePts INT;
    
    SELECT COUNT(DISTINCT account_nbr) INTO activePts FROM analytic_data 
	WHERE ((serviceLocation<>"" AND Service_Location=serviceLocation) OR (providerName<>"" AND provider=providerName) OR (insuranceCompanyName<>"" AND Primary_Insurance_Name=insuranceCompanyName) OR (cptCode<>"" AND cptcode=cptCode)) 
	AND Date_of_Service> (SELECT DATE_SUB(MAX(Date_of_Service), INTERVAL 1 YEAR) FROM analytic_data WHERE practice_id=practiceId)
	AND practice_id=practiceId ;
RETURN activePts;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost FUNCTION func_CKD_Patients(practiceId INT) RETURNS INT(11)
    READS SQL DATA
    DETERMINISTIC
BEGIN
	DECLARE activePts INT;
	
	SELECT COUNT(DISTINCT account_nbr) INTO activePts FROM analytic_data WHERE practice_id=practiceId
	AND (icd_1 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_2 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
	AND icd_3 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_4 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
	AND icd_5 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') AND icd_6 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\') 
	AND icd_7 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\')  AND icd_8 NOT IN(SELECT ckdcode FROM ckd_code WHERE codeName=\'ESRD\'));
	RETURN activePts;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost FUNCTION func_ESRD_Patients(practiceId INT) RETURNS INT(11)
    READS SQL DATA
    DETERMINISTIC
BEGIN
	DECLARE activePts INT;
	
	SELECT COUNT(DISTINCT account_nbr) INTO activePts FROM analytic_data WHERE practice_id=practiceId
	AND (icd_1 IN(SELECT ckdcode FROM ckd_code WHERE codeName="ESRD") OR icd_2 IN (SELECT ckdcode FROM ckd_code WHERE codeName="ESRD") 
	OR icd_3 IN(SELECT ckdcode FROM ckd_code WHERE codeName="ESRD") OR icd_4 IN(SELECT ckdcode FROM ckd_code WHERE codeName="ESRD") 
	OR icd_5 IN(SELECT ckdcode FROM ckd_code WHERE codeName="ESRD")
	OR icd_6 IN(SELECT ckdcode FROM ckd_code WHERE codeName="ESRD") OR icd_7 IN(SELECT ckdcode FROM ckd_code WHERE codeName="ESRD")  
	OR icd_8 IN(SELECT ckdcode FROM ckd_code WHERE codeName="ESRD"));
	
	RETURN activePts;
    END');

        DB::unprepared('CREATE DEFINER=root@localhost FUNCTION func_newPatients(practiceId INT) RETURNS INT(11)
    READS SQL DATA
    DETERMINISTIC
BEGIN
	DECLARE activePts INT;
	
	SELECT COUNT(DISTINCT currentYearPts.account_nbr) INTO activePts FROM 
	(
	SELECT DISTINCT account_nbr  FROM analytic_data 
	WHERE Date_of_Service> (SELECT DATE_SUB(MAX(Date_of_Service), INTERVAL 1 YEAR) FROM analytic_data WHERE practice_id=practiceId)
	AND practice_id=practiceId
	) currentYearPts
	LEFT JOIN
	(
	SELECT DISTINCT account_nbr FROM analytic_data 
	WHERE Date_of_Service<= (SELECT DATE_SUB(MAX(Date_of_Service), INTERVAL 1 YEAR) FROM analytic_data WHERE practice_id=practiceId)
	AND practice_id=practiceId
	) previousYearPts ON(currentYearPts.account_nbr=previousYearPts.account_nbr)
	WHERE previousYearPts.account_nbr IS NULL;
	
	RETURN activePts;
    END');


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procedures');
    }
}
