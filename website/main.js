


async function loadScholarships(containerId = 'cardsContainer', search = ''){
  const container = document.getElementById(containerId);
  if(!container) return;

  const url = `/ScholarVerse/backend/All_Scholarships.php` + (search ? `?search=${encodeURIComponent(search)}` : '');
  try{
    const res = await fetch(url);
    const text = await res.text(); 
    container.innerHTML = text;
  }catch(err){
    container.innerHTML = `<p class="error">حدث خطأ في جلب البيانات. تأكدي من تشغيل XAMPP وأن مسار الـbackend صحيح.</p>`;
    console.error(err);
  }
}

const scholarships = [
  { title: "Oxford University Scholarship", country: "UK", field: "Engineering" },
  { title: "Harvard Scholarship", country: "USA", field: "Business" },
  { title: "DAAD Scholarship", country: "Germany", field: "Medicine" },
  { title: "Tokyo University Scholarship", country: "Japan", field: "Computer Science" },
  { title: "Ain Shams Merit Scholarship", country: "Egypt", field: "Information Systems" }
];

function searchScholarships() {
  const query = document.getElementById("searchInput").value.toLowerCase();
  const resultsDiv = document.getElementById("results");

  const results = scholarships.filter(s =>
    s.title.toLowerCase().includes(query) ||
    s.country.toLowerCase().includes(query) ||
    s.field.toLowerCase().includes(query)
  );

  if (results.length === 0) {
    resultsDiv.innerHTML = "<p>No scholarships found for your search.</p>";
    return;
  }

  resultsDiv.innerHTML = results.map(s => `
    <div class="result-card">
      <h3>${s.title}</h3>
      <p><strong>Country:</strong> ${s.country}</p>
      <p><strong>Field:</strong> ${s.field}</p>
    </div>
  `).join('');
}


// ========== TOGGLE (View All ↔ Back) ==========
let showingAll = false; 

function toggleScholarships() {
  const btn = document.getElementById("toggleViewBtn");
  const resultsDiv = document.getElementById("results");

  if (!showingAll) {
    btn.textContent = "Back";
    loadAllScholarships();
    showingAll = true;
  } else {
    btn.textContent = "View All Scholarships";
    resultsDiv.innerHTML = ""; 
    showingAll = false;
  }
}

function loadAllScholarships() {
  const resultsDiv = document.getElementById("results");
  resultsDiv.innerHTML = "<p>Loading scholarships...</p>";

  
  const scholarships = [
    { title: "Ain Shams Merit Scholarship", country: "Egypt", field: "Information Systems", year: 2025 },
    { title: "Tokyo University Scholarship", country: "Japan", field: "Computer Science", year: 2024 },
    { title: "DAAD Scholarship", country: "Germany", field: "Medicine", year: 2023 },
    { title: "Harvard Scholarship", country: "USA", field: "Business", year: 2022 },
    { title: "Oxford University Scholarship", country: "UK", field: "Engineering", year: 2021 },
  ];

  const sorted = scholarships.sort((a, b) => b.year - a.year);

  
  resultsDiv.innerHTML = sorted.map(s => `
    <div class="result-card">
      <h3>${s.title}</h3>
      <p><strong>Country:</strong> ${s.country}</p>
      <p><strong>Field:</strong> ${s.field}</p>
      <p><strong>Year:</strong> ${s.year}</p>
    </div>
  `).join('');
}
