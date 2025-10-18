USE cucasDWH;
GO

CREATE OR ALTER PROCEDURE Silver.silver_Load
AS
BEGIN
    DECLARE @Start_Time DATETIME, 
            @End_Time DATETIME, 
            @Start_Batch DATETIME, 
            @End_Batch DATETIME;

    BEGIN TRY
        SET @Start_Batch = GETDATE();
        PRINT '>> Loading The Silver Layer';

        -------------------------------
        -- Applicant
        -------------------------------
        PRINT '>> Truncating table Silver.Applicant';
        TRUNCATE TABLE Silver.Applicant;

        PRINT '>> Inserting data into Silver.Applicant';
        SET @Start_Time = GETDATE();

        INSERT INTO Silver.Applicant 
        SELECT 
            ApplicantID,
            FullName,                        
            Nationality,
            CurrentLevel,
            YearOfStudy,
            CASE FinancialSupportNeeded 
                WHEN 'Y' THEN 'Yes' 
                WHEN 'N' THEN 'No'
            END AS FinancialSupportNeeded,
            FamilyIncome,
            InstitutionName,
            Major,
            Email,
            CASE Gender 
                WHEN 'M' THEN 'Male' 
                WHEN 'F' THEN 'Female'
            END AS Gender,
            GPA,
            Country,
            City,
            DATEDIFF(YEAR, DOB, GETDATE()) - 
                CASE 
                    WHEN DATEADD(YEAR, DATEDIFF(YEAR, DOB, GETDATE()), DOB) > GETDATE() 
                    THEN 1 ELSE 0 
                END
        FROM Bronze.Applicant;

        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (Applicant): ' + CAST(DATEDIFF(SECOND, @Start_Time, @End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- University
        -------------------------------
        PRINT '>> Truncating table Silver.University';
        TRUNCATE TABLE Silver.University;

        PRINT '>> Inserting data into Silver.University';
        SET @Start_Time = GETDATE();

        INSERT INTO Silver.University
        SELECT 
            Uni_ID,   
            University,      
            [Location],           
            Rating
        FROM Bronze.University;

        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (University): ' + CAST(DATEDIFF(SECOND, @Start_Time, @End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- FinanceDetails
        -------------------------------
        PRINT '>> Truncating table Silver.FinanceDetails';
        TRUNCATE TABLE Silver.FinanceDetails;

        PRINT '>> Inserting data into Silver.FinanceDetails';
        SET @Start_Time = GETDATE();

        INSERT INTO Silver.FinanceDetails
        SELECT 
            FinanceID,
            MinScholarshipCoverageTuition,
            MaxScholarshipCoverageTuition,
            CASE TRIM(ScholarshipCoverageAccommodation)
                WHEN 'Y' THEN 'Yes'
                WHEN 'N' THEN 'No'
                WHEN 'P' THEN 'Partial'
                ELSE TRIM(ScholarshipCoverageAccommodation)
            END,
            CASE TRIM(ScholarshipCoverageLivingExpense)
                WHEN 'Y' THEN 'Yes'
                WHEN 'N' THEN 'No'
                WHEN 'P' THEN 'Partial'
                ELSE TRIM(ScholarshipCoverageLivingExpense)
            END,
            MinTuitionApplicantNeedToPay,
            MaxTuitionApplicantNeedToPay,
            MinApplicantNeedToPayAccommodation,
            MaxApplicantNeedToPayAccommodation,
            TRIM(ApplicantNeedToPayAccommodationCategoryType),
            MinApplicantNeedToPayLivingExpense,
            MaxApplicantNeedToPayLivingExpense,
            TRIM(LivingExpenseApplicantNeedToPayCategoryType),
            Tuition,
            TRIM(TuitionCategoryType),
            DeadlineForPayment,
            MinApplicationServiceFeeByDollars,
            MaxApplicationServiceFeeByDollars
        FROM Bronze.FinanceDetails;

        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (FinanceDetails): ' + CAST(DATEDIFF(SECOND, @Start_Time, @End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- Scholarship
        -------------------------------
        PRINT '>> Truncating table Silver.Scholarship';
        TRUNCATE TABLE Silver.Scholarship;

        PRINT '>> Inserting data into Silver.Scholarship';
        SET @Start_Time = GETDATE();

        INSERT INTO Silver.Scholarship
        SELECT 
            Schol_ID,
            Uni_ID,
            FinanceID,
            REPLACE(TRIM(Program), '"', ''),
            TRIM(TeachingLanguage),
            TRIM(Degree),
            Duration,
            TRIM(DurationCategoryType),
            StartingDate,
            DeadlineForDocuments,
            StartYear,
            StartMonth,
            TRIM(Category)
        FROM Bronze.Scholarship;

        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (Scholarship): ' + CAST(DATEDIFF(SECOND, @Start_Time, @End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- Recommender
        -------------------------------
        PRINT '>> Truncating table Silver.Recommender';
        TRUNCATE TABLE Silver.Recommender;

        PRINT '>> Inserting data into Silver.Recommender';
        SET @Start_Time = GETDATE();

        INSERT INTO Silver.Recommender
        SELECT RecommenderID, FullName, Email, Position, Institution
        FROM Bronze.Recommender;

        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (Recommender): ' + CAST(DATEDIFF(SECOND, @Start_Time, @End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- RecommendationLetter
        -------------------------------
        PRINT '>> Truncating table Silver.RecommendationLetter';
        TRUNCATE TABLE Silver.RecommendationLetter;

        PRINT '>> Inserting data into Silver.RecommendationLetter';
        SET @Start_Time = GETDATE();

        INSERT INTO Silver.RecommendationLetter
        SELECT 
            RecommenderID, 
            ApplicantID, 
            LetterText, 
            CanLearnQuickly, 
            ProblemSolvingAbility, 
            ResearchSkills, 
            AcademicPerformance
        FROM Bronze.RecommendationLetter;

        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (RecommendationLetter): ' + CAST(DATEDIFF(SECOND, @Start_Time, @End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- ExamType
        -------------------------------
        PRINT '>> Truncating table Silver.ExamType';
        TRUNCATE TABLE Silver.ExamType;

        PRINT '>> Inserting data into Silver.ExamType';
        SET @Start_Time = GETDATE();

        INSERT INTO Silver.ExamType
        SELECT ExamTypeID, ExamName, Provider
        FROM Bronze.ExamType;

        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (ExamType): ' + CAST(DATEDIFF(SECOND, @Start_Time, @End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- ExamResult
        -------------------------------
        PRINT '>> Truncating table Silver.ExamResult';
        TRUNCATE TABLE Silver.ExamResult;

        PRINT '>> Inserting data into Silver.ExamResult';
        SET @Start_Time = GETDATE();

        INSERT INTO Silver.ExamResult (ExamTypeID, ApplicantID, ApplicationID, ExamDate, Score, Result, IsValid)
        SELECT 
            ExamTypeID,
            ApplicantID,
            ApplicationID,  
            ExamDate,
            Score,
            CASE Result
                WHEN 'F' THEN 'Fail'
                WHEN 'P' THEN 'Pass'
                ELSE Result
            END,
            CASE IsValid
                WHEN 'Yes' THEN 'Valid'
                WHEN 'No' THEN 'Invalid'
                WHEN 'Exp' THEN 'Expired'
                ELSE IsValid
            END
        FROM Bronze.ExamResult;

        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (ExamResult): ' + CAST(DATEDIFF(SECOND, @Start_Time, @End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- Interviewer
        -------------------------------
        PRINT '>> Truncating table Silver.Interviewer';
        TRUNCATE TABLE Silver.Interviewer;

        PRINT '>> Inserting data into Silver.Interviewer';
        SET @Start_Time = GETDATE();

        INSERT INTO Silver.Interviewer
        SELECT InterviewerID, Name, Position, Institution, Email
        FROM Bronze.Interviewer;

        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (Interviewer): ' + CAST(DATEDIFF(SECOND, @Start_Time, @End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- Interview
        -------------------------------
        PRINT '>> Truncating table Silver.Interview';
        TRUNCATE TABLE Silver.Interview;

        PRINT '>> Inserting data into Silver.Interview';
        SET @Start_Time = GETDATE();

        INSERT INTO Silver.Interview 
        SELECT  
            InterviewerID,
            ApplicantID,
            ApplicationID,
            InterviewDate,
            Location,
            CASE Result
                WHEN 'F' THEN 'Fail'
                WHEN 'P' THEN 'Pass'
                ELSE Result
            END
        FROM Bronze.Interview;

        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (Interview): ' + CAST(DATEDIFF(SECOND, @Start_Time, @End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- ApplicationPayment
        -------------------------------
        PRINT '>> Truncating table Silver.ApplicationPayment';
        TRUNCATE TABLE Silver.ApplicationPayment;

        PRINT '>> Inserting data into Silver.ApplicationPayment';
        SET @Start_Time = GETDATE();

        INSERT INTO Silver.ApplicationPayment (
            ApplicationID,
            PaymentDate,
            TuitionPay,
            AccommodationPay,
            LivingExpensePay,
            ServiceFee,
            PaymentMethod
        )
        SELECT 
            ApplicationID,
            PaymentDate,
            TuitionPay,
            AccommodationPay,
            LivingExpensePay,
            ServiceFee,
            PaymentMethod
        FROM Bronze.ApplicationPayment;

        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (ApplicationPayment): ' + CAST(DATEDIFF(SECOND, @Start_Time, @End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- END OF PROCESS
        -------------------------------
        SET @End_Batch = GETDATE();
        PRINT '>> Silver layer loading completed';
        PRINT '   Total Load Duration: ' + CAST(DATEDIFF(SECOND, @Start_Batch, @End_Batch) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------------------';
    END TRY

    BEGIN CATCH
        PRINT '>> ERROR OCCURRED DURING LOADING THE SILVER LAYER';
        PRINT '>> ERROR MESSAGE: ' + ERROR_MESSAGE();
        PRINT '-----------------------------------------';
    END CATCH
END
GO

-- Execute procedure
EXEC Silver.silver_Load;


