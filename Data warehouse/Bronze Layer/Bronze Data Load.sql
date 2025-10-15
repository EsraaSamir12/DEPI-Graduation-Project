USE cucasDWH


CREATE OR ALTER PROCEDURE Bronze.bronze_Load 
AS 
BEGIN
    DECLARE @Start_Time DATETIME, @End_Time DATETIME , @Start_Batch DATETIME, @End_Batch DATETIME;
    BEGIN TRY 
	SET @Start_Batch=GETDATE();
	
        PRINT '>> Loading The Bronze Layer'

        -- Applicant
        PRINT '>> Truncating table Bronze.Applicant'
        TRUNCATE TABLE cucasDWH.Bronze.Applicant;
        PRINT '>> Inserting data into Bronze.Applicant'
        SET @Start_Time = GETDATE();
	  INSERT INTO cucasDWH.Bronze.Applicant (
       FullName,
       Nationality,
       CurrentLevel,
       YearOfStudy,
       FinancialSupportNeeded,
       FamilyIncome,
       InstitutionName,
       Major,
       Email,
       DOB,
       Gender,
       GPA,
       Country,
       City
      )
   SELECT 
        FullName,
         Nationality,
         CurrentLevel,
         YearOfStudy,
         FinancialSupportNeeded,
         FamilyIncome,
         InstitutionName,
          Major,
          Email,
          DOB,
          Gender,
          GPA,
          Country,
          City
    FROM cucasDB.dbo.Applicant;
              
         
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- University
        PRINT '>> Truncating table Bronze.University'
        TRUNCATE TABLE cucasDWH.Bronze.University;
        PRINT '>> Inserting data into Bronze.University'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.University
        SELECT *
        FROM cucasDB.dbo.University;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- FinanceDetails
        PRINT '>> Truncating table Bronze.FinanceDetails'
        TRUNCATE TABLE cucasDWH.Bronze.FinanceDetails;
        PRINT '>> Inserting data into Bronze.FinanceDetails'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.FinanceDetails
        SELECT *
        FROM cucasDB.dbo.FinanceDetails;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- Scholarship
        PRINT '>> Truncating table Bronze.Scholarship'
        TRUNCATE TABLE cucasDWH.Bronze.Scholarship;
        PRINT '>> Inserting data into Bronze.Scholarship'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.Scholarship
        SELECT *
        FROM cucasDB.dbo.Scholarship;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- Recommender
        PRINT '>> Truncating table Bronze.Recommender'
        TRUNCATE TABLE cucasDWH.Bronze.Recommender;
        PRINT '>> Inserting data into Bronze.Recommender'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.Recommender
        SELECT *
        FROM cucasDB.dbo.Recommender;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- RecommendationLetter
        PRINT '>> Truncating table Bronze.RecommendationLetter'
        TRUNCATE TABLE cucasDWH.Bronze.RecommendationLetter;
        PRINT '>> Inserting data into Bronze.RecommendationLetter'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.RecommendationLetter
        SELECT *
        FROM cucasDB.dbo.RecommendationLetter;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- ExamType
        PRINT '>> Truncating table Bronze.ExamType'
        TRUNCATE TABLE cucasDWH.Bronze.ExamType;
        PRINT '>> Inserting data into Bronze.ExamType'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.ExamType
        SELECT *
        FROM cucasDB.dbo.ExamType;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- ExamResult
        PRINT '>> Truncating table Bronze.ExamResult'
        TRUNCATE TABLE cucasDWH.Bronze.ExamResult;
        PRINT '>> Inserting data into Bronze.ExamResult'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.ExamResult
        SELECT *
        FROM cucasDB.dbo.ExamResult;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- Support
        PRINT '>> Truncating table Bronze.Support'
        TRUNCATE TABLE cucasDWH.Bronze.Support;
        PRINT '>> Inserting data into Bronze.Support'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.Support
        SELECT *
        FROM cucasDB.dbo.Support;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- ApplicantFinancialSupport
        PRINT '>> Truncating table Bronze.ApplicantFinancialSupport'
        TRUNCATE TABLE cucasDWH.Bronze.ApplicantFinancialSupport;
        PRINT '>> Inserting data into Bronze.ApplicantFinancialSupport'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.ApplicantFinancialSupport
        SELECT *
        FROM cucasDB.dbo.ApplicantFinancialSupport;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- Committee
        PRINT '>> Truncating table Bronze.Committee'
        TRUNCATE TABLE cucasDWH.Bronze.Committee;
        PRINT '>> Inserting data into Bronze.Committee'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.Committee
        SELECT *
        FROM cucasDB.dbo.Committee;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- CommitteMember
        PRINT '>> Truncating table Bronze.CommitteMember'
        TRUNCATE TABLE cucasDWH.Bronze.CommitteMember;
        PRINT '>> Inserting data into Bronze.CommitteMember'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.CommitteMember
        SELECT *
        FROM cucasDB.dbo.CommitteMember;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- Interviewer
        PRINT '>> Truncating table Bronze.Interviewer'
        TRUNCATE TABLE cucasDWH.Bronze.Interviewer;
        PRINT '>> Inserting data into Bronze.Interviewer'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.Interviewer
        SELECT *
        FROM cucasDB.dbo.Interviewer;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- Interview
        PRINT '>> Truncating table Bronze.Interview'
        TRUNCATE TABLE cucasDWH.Bronze.Interview;
        PRINT '>> Inserting data into Bronze.Interview'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.Interview
        SELECT *
        FROM cucasDB.dbo.Interview;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- Application
        PRINT '>> Truncating table Bronze.Application'
        TRUNCATE TABLE cucasDWH.Bronze.Application;
        PRINT '>> Inserting data into Bronze.Application'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.Application
        SELECT *
        FROM cucasDB.dbo.Application;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'

        -- ApplicationPayment
        PRINT '>> Truncating table Bronze.ApplicationPayment'
        TRUNCATE TABLE cucasDWH.Bronze.ApplicationPayment;
        PRINT '>> Inserting data into Bronze.ApplicationPayment'
        SET @Start_Time = GETDATE();
        INSERT INTO cucasDWH.Bronze.ApplicationPayment
        SELECT *
        FROM cucasDB.dbo.ApplicationPayment;    
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------'
		SET @End_Batch=GETDATE();

        PRINT '>> Bronze layer loading completed: '
		PRINT '   Total Load Duration '+ CAST(DATEDIFF(SECOND,@Start_Batch,@End_Batch) AS NVARCHAR) + ' seconds';
		PRINT '-----------------------------------------'

    END TRY 
    BEGIN CATCH
        PRINT '>> ERROR OCCURRED DURING LOADING THE BRONZE LAYER'
        PRINT '>> ERROR MESSAGE: ' + ERROR_MESSAGE();
		PRINT '-----------------------------------------'
    END CATCH
END

Exec Bronze.bronze_Load
