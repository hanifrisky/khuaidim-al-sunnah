
const quizData = <? php echo \Illuminate\Support\Js:: from($kumpulanSoal) ?>;
const multiplierNilai = <? php echo \Illuminate\Support\Js:: from($multiplierNilai) ?>;
// Data Soal dari dokumen AH.docx
//const quizData = [];
let jawabanBenar = 0;

let currentQIndex = 0;
let currentSelection = [];

function loadQuestion() {
    const data = quizData[currentQIndex];

    currentSelection = [];
    document.getElementById('answerArea').innerHTML =
        '<div class="answer-placeholder">Ketuk pilihan di bawah untuk mengurutkan</div>';

    document.getElementById('feedbackMsg').style.display = 'none';
    document.getElementById('nextBtn').style.display = 'none';
    document.getElementById('progressText').innerText =
        `Soal ${currentQIndex + 1} dari ${quizData.length}`;

    document.getElementById('questionText').innerText = data.q;

    const optsDiv = document.getElementById('optionsArea');
    optsDiv.innerHTML = '';

    Object.keys(data.options).forEach(key => {
        const btn = document.createElement('div');
        btn.className = 'btn-option';
        btn.id = 'opt-' + key;
        btn.onclick = () => selectOption(key, data.options[key]);

        btn.innerHTML =
            `<span>${data.options[key]}</span>
             <span class="label">${key.toUpperCase()}</span>`;

        optsDiv.appendChild(btn);
    });
}

function selectOption(key, text) {
    if (currentSelection.length >= 3) return; // Sudah penuh
    if (currentSelection.includes(key)) return; // Sudah dipilih

    currentSelection.push(key);

    // Sembunyikan dari bawah
    document.getElementById('opt-' + key).style.visibility = 'hidden';

    // Tampilkan di atas (Answer Area)
    const answerArea = document.getElementById('answerArea');
    if (currentSelection.length === 1) answerArea.innerHTML = ''; // Hapus placeholder

    const selectedItem = document.createElement('div');
    selectedItem.className = 'btn-option selected-item';
    selectedItem.innerHTML = `<span>${text}</span> <span class="label">${key.toUpperCase()}</span>`;
    answerArea.appendChild(selectedItem);

    // Cek jika sudah 3 item
    if (currentSelection.length === 3) {
        checkAnswer();
    }
}

function checkAnswer() {
    const correctOrder = quizData[currentQIndex].order;
    const feedback = document.getElementById('feedbackMsg');

    // Bandingkan array
    const isCorrect = JSON.stringify(currentSelection) === JSON.stringify(correctOrder);

    feedback.style.display = 'block';
    if (isCorrect) {
        jawabanBenar++;
        feedback.className = 'feedback correct';
        feedback.innerHTML = '✅ Benar! Urutan sesuai hadis.';
    } else {
        feedback.className = 'feedback wrong';
        feedback.innerHTML = `❌ Kurang Tepat. <br>Urutan Benar: ${correctOrder.join(' - ').toUpperCase()}`;
    }

    document.getElementById('nextBtn').style.display = 'block';
}

function nextQuestion() {
    currentQIndex++;
    if (currentQIndex < quizData.length) {
        loadQuestion();
    } else {
        const nilai = jawabanBenar * multiplierNilai;
        // Panggil method Livewire Page
        Livewire.dispatch('selesai-kuis', {
            nilai: nilai
        });
        document.querySelector('.container').innerHTML = '<h2>Selesai!</h2><p align="center">Anda telah menyelesaikan semua soal.</p><button class="btn-next" style="display:block" onclick="location.reload()">Ulangi</button>';
    }
}

// Start
loadQuestion();
