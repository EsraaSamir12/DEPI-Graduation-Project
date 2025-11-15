import pyodbc
import pandas as pd
from datetime import datetime
import os

# ================== إعداد الاتصال ==================
print("جاري الاتصال بقاعدة البيانات gold...")

try:
    conn = pyodbc.connect(
        'DRIVER={ODBC Driver 18 for SQL Server};'
        'SERVER=localhost;'
        'DATABASE=gold;'
        'Trusted_Connection=yes;'
    )
    print("تم الاتصال بنجاح!\n")
except Exception as e:
    print("فشل الاتصال:", e)
    exit()

# ================== قائمة الـ Views ==================
views = [
    "ApplicantDIM",
    "ApplicationPaymentDIM",
    "FinancialSupportDIM",
    "RecommendationDIM",
    "CommitteeDIM",
    "ScholarshipDIM",
    "ExamDim",
    "InterviewDim",
    "DateDIM",
    "ApplicationFact"
]

# ================== مجلد الحفظ ==================
output_folder = "Gold_Layer_Output"
os.makedirs(output_folder, exist_ok=True)

# ================== جلب البيانات وحفظها ==================
all_dfs = {}  # لتخزين الـ DataFrames للتحليل لاحقًا

for view in views:
    try:
        print(f"جاري جلب بيانات: gold.{view} ...")
        query = f"SELECT * FROM gold.{view}"
        df = pd.read_sql(query, conn)
        
        # حفظ في Excel
        filename = f"{output_folder}/{view}.xlsx"
        df.to_excel(filename, index=False)
        
        # تخزين في الذاكرة
        all_dfs[view] = df
        
        print(f"تم حفظ {len(df):,} سجل → {filename}\n")
        
    except Exception as e:
        print(f"خطأ في جلب {view}: {e}\n")

# إغلاق الاتصال
conn.close()

# ================== تحليل سريع على ApplicationFact ==================
if "ApplicationFact" in all_dfs:
    fact = all_dfs["ApplicationFact"]
    print("تحليل سريع على ApplicationFact:")
    print(f"   • إجمالي الطلبات: {len(fact):,}")
    print(f"   • حالات النتيجة:")
    print(fact['Result'].value_counts(dropna=False).to_string())
    print(f"   • متوسط الدرجة: {fact['Score'].mean():.2f}" if 'Score' in fact.columns else "   • لا توجد درجات")
    print(f"   • تاريخ أول طلب: {fact['ApplicationDate'].min()}" if 'ApplicationDate' in fact.columns else "")
    print(f"   • تاريخ آخر طلب: {fact['ApplicationDate'].max()}" if 'ApplicationDate' in fact.columns else "")
    print("-" * 50)

# ================== تقرير نهائي ==================
print(f"تم حفظ جميع الملفات في المجلد: {output_folder}")
print(f"عدد الـ Views التي تم جلبها: {len(all_dfs)}")
print(f"التاريخ والوقت: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}")
