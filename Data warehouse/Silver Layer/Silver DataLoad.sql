USE cucasDWH;
GO

CREATE OR ALTER PROCEDURE Silver.silver_Load
AS
BEGIN
    DECLARE @Start_Time DATETIME, @End_Time DATETIME, @Start_Batch DATETIME, @End_Batch DATETIME;

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
                CASE WHEN DATEADD(YEAR, DATEDIFF(YEAR, DOB, GETDATE()), DOB) > GETDATE() THEN 1 ELSE 0 END
        FROM Bronze.Applicant;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (Applicant): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
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
        PRINT '>> Load Duration (University): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
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
        PRINT '>> Load Duration (FinanceDetails): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
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
        PRINT '>> Load Duration (Scholarship): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
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
        PRINT '>> Load Duration (Recommender): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- RecommendationLetter
        -------------------------------
        PRINT '>> Truncating table Silver.RecommendationLetter';
        TRUNCATE TABLE Silver.RecommendationLetter;

        PRINT '>> Inserting data into Silver.RecommendationLetter';
        SET @Start_Time = GETDATE();
        INSERT INTO Silver.RecommendationLetter
        SELECT RecommenderID, ApplicantID, LetterText, CanLearnQuickly, ProblemSolvingAbility, ResearchSkills, AcademicPerformance
        FROM Bronze.RecommendationLetter;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (RecommendationLetter): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- ExamType
        -------------------------------
        PRINT '>> Truncating table Silver.ExamType';
        TRUNCATE TABLE Silver.ExamType;

        PRINT '>> Inserting data into Silver.ExamType';
        SET @Start_Time = GETDATE();
        INSERT INTO Silver.ExamType
        SELECT ExamTypeID, ExamName, Provider FROM Bronze.ExamType;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (ExamType): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- ExamResult
        -------------------------------
        PRINT '>> Truncating table Silver.ExamResult';
        TRUNCATE TABLE Silver.ExamResult;

        PRINT '>> Inserting data into Silver.ExamResult';
        SET @Start_Time = GETDATE();
        INSERT INTO Silver.ExamResult
        SELECT ExamTypeID, ApplicantID, ExamDate, Score, Result, IsValid
        FROM Bronze.ExamResult;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (ExamResult): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- Support
        -------------------------------
        PRINT '>> Truncating table Silver.Support';
        TRUNCATE TABLE Silver.Support;

        PRINT '>> Inserting data into Silver.Support';
        SET @Start_Time = GETDATE();
        INSERT INTO Silver.Support
        SELECT SupportID, SupportType, MaxAmount, Duration, Recurring
        FROM Bronze.Support;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (Support): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- ApplicantFinancialSupport
        -------------------------------
        PRINT '>> Truncating table Silver.ApplicantFinancialSupport';
        TRUNCATE TABLE Silver.ApplicantFinancialSupport;

        PRINT '>> Inserting data into Silver.ApplicantFinancialSupport';
        SET @Start_Time = GETDATE();
        INSERT INTO Silver.ApplicantFinancialSupport
        SELECT 
            ApplicantID,
            SupportID,
            RequestedSupportAmount,
            SupportReason,
            CASE ApprovalStatus
                WHEN 'REJ' THEN 'Rejected'
                WHEN 'APV' THEN 'Approve'
                ELSE ApprovalStatus
            END
        FROM Bronze.ApplicantFinancialSupport;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (ApplicantFinancialSupport): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- Committee
        -------------------------------
        PRINT '>> Truncating table Silver.Committee';
        TRUNCATE TABLE Silver.Committee;

        PRINT '>> Inserting data into Silver.Committee';
        SET @Start_Time = GETDATE();
        INSERT INTO Silver.Committee
        SELECT CommitteeID, CommitteeName FROM Bronze.Committee;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (Committee): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- CommitteMember
        -------------------------------
        PRINT '>> Truncating table Silver.CommitteMember';
        TRUNCATE TABLE Silver.CommitteMember;

        PRINT '>> Inserting data into Silver.CommitteMember';
        SET @Start_Time = GETDATE();
        INSERT INTO Silver.CommitteMember
        SELECT 
            ReviewerID,
            Name,
            Email,
            CASE Status
                WHEN 'Act' THEN 'Active'
                WHEN 'Inact' THEN 'Inactive'
                ELSE Status
            END,
            CurrentWorkedLoad,
            Institution,
            Position,
            Specialization,
            Department,
            MaxReviewsCapacity,
            YearsOfExperience,
            CommitteeID
        FROM Bronze.CommitteMember;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (CommitteMember): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
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
        PRINT '>> Load Duration (Interviewer): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
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
            InterviewDate,
            Location,
            CASE Result
                WHEN 'REJ' THEN 'Rejected'
                WHEN 'Acc' THEN 'Accepted'
                ELSE Result
            END
        FROM Bronze.Interview;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (Interview): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- Application
        -------------------------------
        PRINT '>> Truncating table Silver.Application';
        TRUNCATE TABLE Silver.Application;

        PRINT '>> Inserting data into Silver.Application';
        SET @Start_Time = GETDATE();
        INSERT INTO Silver.Application
        SELECT 
            ApplicationID,
            ApplicantID,
            ScholID,
            ApplicationDate,
            CommitteeID,
            Score,
            Comment,
            CASE Recommendation
                WHEN 'Rej' THEN 'Rejected'
                WHEN 'PND' THEN 'Pending'
                WHEN 'Acc' THEN 'Accepted'
                ELSE Recommendation
            END
        FROM Bronze.Application;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (Application): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';


        -------------------------------
        -- ApplicationPayment
        -------------------------------
        PRINT '>> Truncating table Silver.ApplicationPayment';
        TRUNCATE TABLE Silver.ApplicationPayment;

        PRINT '>> Inserting data into Silver.ApplicationPayment';
        SET @Start_Time = GETDATE();
        INSERT INTO Silver.ApplicationPayment
        SELECT 
            PaymentID,
            ApplicationID,
            PaymentDate,
            TuitionPay,
            AccommodationPay,
            LivingExpensePay,
            ServiceFee,
            TotalAmount,
            PaymentMethod
        FROM Bronze.ApplicationPayment;
        SET @End_Time = GETDATE();
        PRINT '>> Load Duration (ApplicationPayment): ' + CAST(DATEDIFF(SECOND,@Start_Time,@End_Time) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------';

        -------------------------------
        -- End of Process
        -------------------------------
        SET @End_Batch = GETDATE();
        PRINT '>> Silver layer loading completed';
        PRINT '   Total Load Duration: ' + CAST(DATEDIFF(SECOND,@Start_Batch,@End_Batch) AS NVARCHAR) + ' seconds';
        PRINT '-----------------------------------------';
    END TRY

    BEGIN CATCH
        PRINT '>> ERROR OCCURRED DURING LOADING THE SILVER LAYER';
        PRINT '>> ERROR MESSAGE: ' + ERROR_MESSAGE();
        PRINT '-----------------------------------------';
    END CATCH
END
GO

-- Execute
EXEC Silver.silver_Load;
