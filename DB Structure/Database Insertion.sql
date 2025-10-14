BULK INSERT Applicant
FROM 'D:\Final DEPI GP\DataSet\applicants.csv'
WITH (
    FIRSTROW = 2, 
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',  
    CODEPAGE = '65001',    
    TABLOCK
);


BULK INSERT University
FROM 'D:\Final DEPI GP\DataSet\University.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);

BULK INSERT FinanceDetails
FROM 'D:\Final DEPI GP\DataSet\FinanceDetails.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);

BULK INSERT Scholarship
FROM 'D:\Final DEPI GP\DataSet\NewScholarship.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);


BULK INSERT Recommender
FROM 'D:\Final DEPI GP\DataSet\recommenders.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);

BULK INSERT RecommendationLetter
FROM 'D:\Final DEPI GP\DataSet\recommendation letter.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);

BULK INSERT ExamType
FROM 'D:\Final DEPI GP\DataSet\ExamsType.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);

BULK INSERT ExamResult
FROM 'D:\Final DEPI GP\DataSet\Exams.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);

BULK INSERT Support
FROM 'D:\Final DEPI GP\DataSet\FinancialSupports.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);

BULK INSERT ApplicantFinancialSupport
FROM 'D:\Final DEPI GP\DataSet\ApplicantSupport_Final.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);

BULK INSERT Committee
FROM 'D:\Final DEPI GP\DataSet\Committee.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);


BULK INSERT CommitteMember
FROM 'D:\Final DEPI GP\DataSet\Committee member.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);



BULK INSERT Interviewer
FROM 'D:\Final DEPI GP\DataSet\interviewers.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);

BULK INSERT Interview
FROM 'D:\Final DEPI GP\DataSet\Applicant_Interviews.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);

BULK INSERT Application
FROM 'D:\Final DEPI GP\DataSet\Application.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);

BULK INSERT ApplicationPayment
FROM 'D:\Final DEPI GP\DataSet\FinancePayments.csv'
WITH (
    FIRSTROW = 2,
    FIELDTERMINATOR = ',', 
    ROWTERMINATOR = '\n',
    CODEPAGE = '65001',    
    TABLOCK
);

