
-----------------------------------------
--  Data Quality Checks for Bronze Layer
-----------------------------------------


------ Checking NULL and Duplicates Values---
-- Applicant
SELECT COUNT(*) AS [Duplication count], ApplicantID
FROM Bronze.Applicant
GROUP BY ApplicantID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.Applicant
WHERE ApplicantID IS NULL OR FullName IS NULL OR Nationality IS NULL OR CurrentLevel IS NULL OR
      YearOfStudy IS NULL OR FinancialSupportNeeded IS NULL OR FamilyIncome IS NULL OR
      InstitutionName IS NULL OR Major IS NULL OR Email IS NULL OR DOB IS NULL OR
      Gender IS NULL OR GPA IS NULL OR Country IS NULL OR City IS NULL;


-- University
SELECT COUNT(*) AS [Duplication count], Uni_ID
FROM Bronze.University
GROUP BY Uni_ID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.University
WHERE Uni_ID IS NULL OR University IS NULL OR [Location] IS NULL OR Rating IS NULL;


-- FinanceDetails
SELECT COUNT(*) AS [Duplication count], FinanceID
FROM Bronze.FinanceDetails
GROUP BY FinanceID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.FinanceDetails
WHERE FinanceID IS NULL OR MinScholarshipCoverageTuition IS NULL OR MaxScholarshipCoverageTuition IS NULL OR
      ScholarshipCoverageAccommodation IS NULL OR ScholarshipCoverageLivingExpense IS NULL OR
      MinTuitionApplicantNeedToPay IS NULL OR MaxTuitionApplicantNeedToPay IS NULL OR
      Tuition IS NULL OR TuitionCategoryType IS NULL OR DeadlineForPayment IS NULL;


-- Scholarship
SELECT COUNT(*) AS [Duplication count], Schol_ID
FROM Bronze.Scholarship
GROUP BY Schol_ID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.Scholarship
WHERE Schol_ID IS NULL OR Uni_ID IS NULL OR FinanceID IS NULL OR Program IS NULL OR
      TeachingLanguage IS NULL OR Degree IS NULL OR Duration IS NULL OR
      StartingDate IS NULL OR DeadlineForDocuments IS NULL;


-- Recommender
SELECT COUNT(*) AS [Duplication count], RecommenderID
FROM Bronze.Recommender
GROUP BY RecommenderID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.Recommender
WHERE RecommenderID IS NULL OR FullName IS NULL OR Email IS NULL OR Position IS NULL OR Institution IS NULL;


-- RecommendationLetter
SELECT COUNT(*) AS [Duplication count], RecommenderID, ApplicantID
FROM Bronze.RecommendationLetter
GROUP BY RecommenderID, ApplicantID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.RecommendationLetter
WHERE RecommenderID IS NULL OR ApplicantID IS NULL OR LetterText IS NULL OR
      CanLearnQuickly IS NULL OR ProblemSolvingAbility IS NULL OR
      ResearchSkills IS NULL OR AcademicPerformance IS NULL;


-- ExamType
SELECT COUNT(*) AS [Duplication count], ExamTypeID
FROM Bronze.ExamType
GROUP BY ExamTypeID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.ExamType
WHERE ExamTypeID IS NULL OR ExamName IS NULL OR Provider IS NULL;


-- ExamResult
SELECT COUNT(*) AS [Duplication count], ExamTypeID, ApplicantID
FROM Bronze.ExamResult
GROUP BY ExamTypeID, ApplicantID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.ExamResult
WHERE ExamTypeID IS NULL OR ApplicantID IS NULL OR ExamDate IS NULL OR
      Score IS NULL OR Result IS NULL OR IsValid IS NULL;


-- Support
SELECT COUNT(*) AS [Duplication count], SupportID
FROM Bronze.Support
GROUP BY SupportID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.Support
WHERE SupportID IS NULL OR SupportType IS NULL OR MaxAmount IS NULL OR Duration IS NULL OR Recurring IS NULL;


-- ApplicantFinancialSupport
SELECT COUNT(*) AS [Duplication count], ApplicantID, SupportID
FROM Bronze.ApplicantFinancialSupport
GROUP BY ApplicantID, SupportID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.ApplicantFinancialSupport
WHERE ApplicantID IS NULL OR SupportID IS NULL OR RequestedSupportAmount IS NULL OR
      SupportReason IS NULL OR ApprovalStatus IS NULL;


-- Committee
SELECT COUNT(*) AS [Duplication count], CommitteeID
FROM Bronze.Committee
GROUP BY CommitteeID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.Committee
WHERE CommitteeID IS NULL OR CommitteeName IS NULL;


-- CommitteMember
SELECT COUNT(*) AS [Duplication count], ReviewerID
FROM Bronze.CommitteMember
GROUP BY ReviewerID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.CommitteMember
WHERE ReviewerID IS NULL OR Name IS NULL OR Email IS NULL OR Status IS NULL OR
      Institution IS NULL OR Position IS NULL OR Specialization IS NULL OR
      Department IS NULL OR CommitteeID IS NULL;


-- Interviewer
SELECT COUNT(*) AS [Duplication count], InterviewerID
FROM Bronze.Interviewer
GROUP BY InterviewerID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.Interviewer
WHERE InterviewerID IS NULL OR Name IS NULL OR Position IS NULL OR Institution IS NULL OR Email IS NULL;


-- Interview
SELECT COUNT(*) AS [Duplication count], InterviewerID, ApplicantID
FROM Bronze.Interview
GROUP BY InterviewerID, ApplicantID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.Interview
WHERE InterviewerID IS NULL OR ApplicantID IS NULL OR InterviewDate IS NULL OR Location IS NULL OR Result IS NULL;


-- Application
SELECT COUNT(*) AS [Duplication count], ApplicationID
FROM Bronze.Application
GROUP BY ApplicationID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.Application
WHERE ApplicationID IS NULL OR ApplicantID IS NULL OR ScholID IS NULL OR
      ApplicationDate IS NULL OR CommitteeID IS NULL OR Score IS NULL;


-- ApplicationPayment
SELECT COUNT(*) AS [Duplication count], PaymentID
FROM Bronze.ApplicationPayment
GROUP BY PaymentID
HAVING COUNT(*) > 1;

SELECT COUNT(*) AS [Missing Values count]
FROM Bronze.ApplicationPayment
WHERE PaymentID IS NULL OR ApplicationID IS NULL OR PaymentDate IS NULL OR
      TuitionPay IS NULL OR AccommodationPay IS NULL OR LivingExpensePay IS NULL OR
      ServiceFee IS NULL OR TotalAmount IS NULL OR PaymentMethod IS NULL;


---- Checking an unnecessary spaces-----
-- Applicant
SELECT *
FROM Bronze.Applicant
WHERE FullName != TRIM(FullName)
   OR Nationality != TRIM(Nationality)
   OR CurrentLevel != TRIM(CurrentLevel)
   OR InstitutionName != TRIM(InstitutionName)
   OR Major != TRIM(Major)
   OR Email != TRIM(Email)
   OR Gender != TRIM(Gender)
   OR Country != TRIM(Country)
   OR City != TRIM(City);

-- University
SELECT *
FROM Bronze.University
WHERE University != TRIM(University)
   OR [Location] != TRIM([Location]);

-- FinanceDetails--
SELECT *
FROM Bronze.FinanceDetails
WHERE ScholarshipCoverageAccommodation != TRIM(ScholarshipCoverageAccommodation)
   OR ScholarshipCoverageLivingExpense != TRIM(ScholarshipCoverageLivingExpense)
   OR ApplicantNeedToPayAccommodationCategoryType != TRIM(ApplicantNeedToPayAccommodationCategoryType)
   OR LivingExpenseApplicantNeedToPayCategoryType != TRIM(LivingExpenseApplicantNeedToPayCategoryType)
   OR TuitionCategoryType != TRIM(TuitionCategoryType);

-- Scholarship--
SELECT *
FROM Bronze.Scholarship
WHERE Program != TRIM(Program)
   OR TeachingLanguage != TRIM(TeachingLanguage)
   OR Degree != TRIM(Degree)
   OR DurationCategoryType != TRIM(DurationCategoryType)
   OR Category != TRIM(Category);

-- Recommender
SELECT *
FROM Bronze.Recommender
WHERE FullName != TRIM(FullName)
   OR Email != TRIM(Email)
   OR Position != TRIM(Position)
   OR Institution != TRIM(Institution);

-- RecommendationLetter
SELECT *
FROM Bronze.RecommendationLetter
WHERE LetterText != TRIM(LetterText);

-- ExamType
SELECT *
FROM Bronze.ExamType
WHERE ExamName != TRIM(ExamName)
   OR Provider != TRIM(Provider);

-- ExamResult
SELECT *
FROM Bronze.ExamResult
WHERE Result != TRIM(Result)
   OR IsValid != TRIM(IsValid);

-- Support
SELECT *
FROM Bronze.Support
WHERE SupportType != TRIM(SupportType)
   OR Duration != TRIM(Duration)
   OR Recurring != TRIM(Recurring);

-- ApplicantFinancialSupport
SELECT *
FROM Bronze.ApplicantFinancialSupport
WHERE SupportReason != TRIM(SupportReason)
   OR ApprovalStatus != TRIM(ApprovalStatus);

-- Committee
SELECT *
FROM Bronze.Committee
WHERE CommitteeName != TRIM(CommitteeName);

-- CommitteMember
SELECT *
FROM Bronze.CommitteMember
WHERE Name != TRIM(Name)
   OR Email != TRIM(Email)
   OR Status != TRIM(Status)
   OR Institution != TRIM(Institution)
   OR Position != TRIM(Position)
   OR Specialization != TRIM(Specialization)
   OR Department != TRIM(Department);

-- Interviewer
SELECT *
FROM Bronze.Interviewer
WHERE Name != TRIM(Name)
   OR Position != TRIM(Position)
   OR Institution != TRIM(Institution)
   OR Email != TRIM(Email);

-- Interview
SELECT *
FROM Bronze.Interview
WHERE Location != TRIM(Location)
   OR Result != TRIM(Result);

-- Application
SELECT *
FROM Bronze.Application
WHERE Comment != TRIM(Comment)
   OR Recommendation != TRIM(Recommendation);

-- ApplicationPayment
SELECT *
FROM Bronze.ApplicationPayment
WHERE PaymentMethod != TRIM(PaymentMethod);


-- Data Standardization and consistency--

------------------------------------------------------
-- Applicant   ,   --> F: Female , M:Male
                   --> Y:Yes , N:No
------------------------------------------------------
SELECT Gender, COUNT(*) AS [Count] FROM Bronze.Applicant GROUP BY Gender;
SELECT FinancialSupportNeeded, COUNT(*) AS [Count] FROM Bronze.Applicant GROUP BY FinancialSupportNeeded;
SELECT Nationality, COUNT(*) AS [Count] FROM Bronze.Applicant GROUP BY Nationality;
SELECT CurrentLevel, COUNT(*) AS [Count] FROM Bronze.Applicant GROUP BY CurrentLevel;
SELECT InstitutionName, COUNT(*) AS [Count] FROM Bronze.Applicant GROUP BY InstitutionName;
SELECT Major, COUNT(*) AS [Count] FROM Bronze.Applicant GROUP BY Major;
SELECT Country, COUNT(*) AS [Count] FROM Bronze.Applicant GROUP BY Country;
SELECT City, COUNT(*) AS [Count] FROM Bronze.Applicant GROUP BY City;

------------------------------------------------------
-- University
------------------------------------------------------
SELECT University, COUNT(*) AS [Count] FROM Bronze.University GROUP BY University;
SELECT [Location], COUNT(*) AS [Count] FROM Bronze.University GROUP BY [Location];

------------------------------------------------------
-- FinanceDetails  --> Y:Yes
                   --> N:No
				   -- Partial:P
------------------------------------------------------
SELECT ScholarshipCoverageAccommodation, COUNT(*) AS [Count] FROM Bronze.FinanceDetails GROUP BY ScholarshipCoverageAccommodation;
SELECT ScholarshipCoverageLivingExpense, COUNT(*) AS [Count] FROM Bronze.FinanceDetails GROUP BY ScholarshipCoverageLivingExpense;
SELECT ApplicantNeedToPayAccommodationCategoryType, COUNT(*) AS [Count] FROM Bronze.FinanceDetails GROUP BY ApplicantNeedToPayAccommodationCategoryType;
SELECT LivingExpenseApplicantNeedToPayCategoryType, COUNT(*) AS [Count] FROM Bronze.FinanceDetails GROUP BY LivingExpenseApplicantNeedToPayCategoryType;
SELECT TuitionCategoryType, COUNT(*) AS [Count] FROM Bronze.FinanceDetails GROUP BY TuitionCategoryType;

------------------------------------------------------
-- Scholarship
------------------------------------------------------
SELECT Program, COUNT(*) AS [Count] FROM Bronze.Scholarship GROUP BY Program;
SELECT TeachingLanguage, COUNT(*) AS [Count] FROM Bronze.Scholarship GROUP BY TeachingLanguage;
SELECT Degree, COUNT(*) AS [Count] FROM Bronze.Scholarship GROUP BY Degree;
SELECT DurationCategoryType, COUNT(*) AS [Count] FROM Bronze.Scholarship GROUP BY DurationCategoryType;
SELECT Category, COUNT(*) AS [Count] FROM Bronze.Scholarship GROUP BY Category;

------------------------------------------------------
-- Recommender
------------------------------------------------------
SELECT FullName, COUNT(*) AS [Count] FROM Bronze.Recommender GROUP BY FullName;
SELECT Email, COUNT(*) AS [Count] FROM Bronze.Recommender GROUP BY Email;
SELECT Position, COUNT(*) AS [Count] FROM Bronze.Recommender GROUP BY Position;
SELECT Institution, COUNT(*) AS [Count] FROM Bronze.Recommender GROUP BY Institution;

------------------------------------------------------
-- RecommendationLetter
------------------------------------------------------
SELECT LetterText, COUNT(*) AS [Count] FROM Bronze.RecommendationLetter GROUP BY LetterText;

------------------------------------------------------
-- ExamType
------------------------------------------------------

SELECT ExamName, COUNT(*) AS [Count] FROM Bronze.ExamType GROUP BY ExamName;
SELECT Provider, COUNT(*) AS [Count] FROM Bronze.ExamType GROUP BY Provider;

------------------------------------------------------
-- ExamResult          --> Vailed: Yes
                       --> Invailed: No
					   --> Exp:Expired
------------------------------------------------------
SELECT Result, COUNT(*) AS [Count] FROM Bronze.ExamResult GROUP BY Result;
SELECT IsValid, COUNT(*) AS [Count] FROM Bronze.ExamResult GROUP BY IsValid;
------------------------------------------------------
-- Support
------------------------------------------------------
SELECT SupportType, COUNT(*) AS [Count] FROM Bronze.Support GROUP BY SupportType;
SELECT Duration, COUNT(*) AS [Count] FROM Bronze.Support GROUP BY Duration;
SELECT Recurring, COUNT(*) AS [Count] FROM Bronze.Support GROUP BY Recurring;

------------------------------------------------------
-- ApplicantFinancialSupport  -- > REJ :Rejected
                              -- > APV : Approved
------------------------------------------------------
SELECT SupportReason, COUNT(*) AS [Count] FROM Bronze.ApplicantFinancialSupport GROUP BY SupportReason;
SELECT ApprovalStatus, COUNT(*) AS [Count] FROM Bronze.ApplicantFinancialSupport GROUP BY ApprovalStatus;

------------------------------------------------------
-- Committee
------------------------------------------------------
SELECT CommitteeName, COUNT(*) AS [Count] FROM Bronze.Committee GROUP BY CommitteeName;

------------------------------------------------------
-- CommitteMember
------------------------------------------------------
SELECT Name, COUNT(*) AS [Count] FROM Bronze.CommitteMember GROUP BY Name;
SELECT Email, COUNT(*) AS [Count] FROM Bronze.CommitteMember GROUP BY Email;
SELECT Status, COUNT(*) AS [Count] FROM Bronze.CommitteMember GROUP BY Status;
SELECT Institution, COUNT(*) AS [Count] FROM Bronze.CommitteMember GROUP BY Institution;
SELECT Position, COUNT(*) AS [Count] FROM Bronze.CommitteMember GROUP BY Position;
SELECT Specialization, COUNT(*) AS [Count] FROM Bronze.CommitteMember GROUP BY Specialization;
SELECT Department, COUNT(*) AS [Count] FROM Bronze.CommitteMember GROUP BY Department;

------------------------------------------------------
-- Interviewer
------------------------------------------------------
SELECT Name, COUNT(*) AS [Count] FROM Bronze.Interviewer GROUP BY Name;
SELECT Position, COUNT(*) AS [Count] FROM Bronze.Interviewer GROUP BY Position;
SELECT Institution, COUNT(*) AS [Count] FROM Bronze.Interviewer GROUP BY Institution;
SELECT Email, COUNT(*) AS [Count] FROM Bronze.Interviewer GROUP BY Email;
------------------------------------------------------
-- Interview
------------------------------------------------------
SELECT Location, COUNT(*) AS [Count] FROM Bronze.Interview GROUP BY Location;
SELECT Result, COUNT(*) AS [Count] FROM Bronze.Interview GROUP BY Result;

------------------------------------------------------
-- Application   --> Rej:Rejected
                 --> Pend : Pending
				 --> Acc:Accepted
------------------------------------------------------
SELECT Comment, COUNT(*) AS [Count] FROM Bronze.Application GROUP BY Comment;
SELECT Recommendation, COUNT(*) AS [Count] FROM Bronze.Application GROUP BY Recommendation;

------------------------------------------------------
-- ApplicationPayment
------------------------------------------------------
SELECT PaymentMethod, COUNT(*) AS [Count] FROM Bronze.ApplicationPayment GROUP BY PaymentMethod;
---------------------------------------------------------------------------------------------------


--  Find payments made before the application date
SELECT *
FROM Bronze.ApplicationPayment p
INNER JOIN Bronze.Application a
    ON p.ApplicationID = a.ApplicationID
WHERE p.PaymentDate < a.ApplicationDate;

-- Check if exams happened after interviews but before the application date
SELECT a.ApplicantID,
       e.ExamDate,
       i.InterviewDate,
       a.ApplicationDate
FROM Bronze.Application a
INNER JOIN Bronze.ExamResult e 
    ON a.ApplicationID = e.ApplicationID
INNER JOIN Bronze.Interview i 
    ON a.ApplicationID = i.ApplicationID
WHERE e.ExamDate > i.InterviewDate AND i.InterviewDate < a.ApplicationDate


-- Find applicants who failed the exam but passed the interview
SELECT a.ApplicantID,
       e.Result AS ExamResult,
       i.Result AS InterviewResult
FROM Bronze.Application a
INNER JOIN Bronze.ExamResult e 
    ON a.ApplicationID = e.ApplicationID
INNER JOIN Bronze.Interview i 
    ON a.ApplicationID = i.ApplicationID
WHERE e.Result = 'F'
  AND i.Result = 'P';



-- Retrieve applicants who failed the exam but their application was accepted based on recommendation.
SELECT  
       a.ApplicantID,
       e.ApplicationID,
	   a.ApplicationID,
       e.Result, 
       a.Recommendation
FROM Bronze.Application a
INNER JOIN Bronze.ExamResult e 
    ON a.ApplicationID = e.ApplicationID
WHERE e.Result = 'F'
  AND a.Recommendation = 'Acc' 



-- Retrieve applicants who failed the interview but were accepted in the recommendation.
SELECT a.ApplicantID,
       i.Result,
	   a.ApplicationID,
	   i.ApplicationID,
       a.Recommendation
FROM Bronze.Application a
INNER JOIN Bronze.Interview i 
    ON a.ApplicationID = i.ApplicationID
WHERE i.Result = 'F'
  AND a.Recommendation = 'Acc' ;


-- This query retrieves application payments where the payment date is later than the scholarship’s payment deadline, 
-- and ensures that the scholarship started before the applicant’s application date. 

SELECT p.PaymentDate, f.DeadlineForPayment, ApplicationDate, StartingDate
FROM Bronze.ApplicationPayment p
LEFT JOIN Bronze.Application a
    ON p.ApplicationID = a.ApplicationID
LEFT JOIN Bronze.Scholarship s
    ON a.ScholID = s.Schol_ID
LEFT JOIN Bronze.FinanceDetails f
    ON s.FinanceID = f.FinanceID
WHERE p.PaymentDate > f.DeadlineForPayment
  AND s.StartingDate < a.ApplicationDate;
