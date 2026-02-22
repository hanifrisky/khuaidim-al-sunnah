<?php
$kumpulanSoal =  $this->GetSoal();
$multiplierNilai = $this->multiplierNilai();
// [{"id":1,"hadits_id":1,"tipe":"pemahaman","soal":"Apalahh","media":null,"created_at":"2026-01-06T15:35:22.000000Z","updated_at":"2026-01-11T07:14:44.000000Z","kitab_id":1,"bab_id":1}]
?>
<x-filament-panels::page>
    <style>
        .soal {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            border-radius: 25px;
            min-height: 100vh;
            margin: 0;
            padding-top: 50px;
        }

        .container {
            background: white;
            width: 90%;
            max-width: 600px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 5px;
        }

        .progress {
            text-align: center;
            color: #777;
            font-size: 0.9em;
            margin-bottom: 20px;
        }

        .question-box {
            background: #e8f4fd;
            padding: 15px;
            border-radius: 8px;
            border-left: 5px solid #2196F3;
            margin-bottom: 20px;
            font-size: 1.2em;
            font-weight: bold;
            text-align: right;
            direction: rtl;
        }

        .answer-area {
            min-height: 120px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: #fafafa;
        }

        .answer-placeholder {
            text-align: center;
            color: #aaa;
            padding-top: 40px;
            pointer-events: none;
        }

        .options-area {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-option {
            background: white;
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            text-align: right;
            direction: rtl;
            font-size: 1.1em;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-option:hover {
            background: #f0f8ff;
            border-color: #2196F3;
            transform: translateY(-2px);
        }

        .btn-option .label {
            font-weight: bold;
            color: #2196F3;
            margin-left: 10px;
            font-family: sans-serif;
        }

        /* State saat dipindah ke atas */
        .selected-item {
            background: #e3f2fd;
            border: 1px solid #2196F3;
            color: #0d47a1;
            cursor: default;
        }

        .feedback {
            text-align: center;
            font-weight: bold;
            padding: 15px;
            margin-top: 15px;
            border-radius: 8px;
            display: none;
        }

        .correct {
            background-color: #d4edda;
            color: #155724;
        }

        .wrong {
            background-color: #f8d7da;
            color: #721c24;
        }

        .btn-next {
            display: block;
            width: 100%;
            padding: 12px;
            background: #2196F3;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            margin-top: 15px;
            display: none;
        }

        .btn-finish {
            margin-top: 24px;
            padding: 14px;
            width: 100%;
            border-radius: 999px;
            border: none;
            background: #16a34a;
            color: #ffffff;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-next:hover {
            background: #1976D2;
        }

        @media (max-width: 480px) {
            .container {
                padding: 15px;
                width: 95%;
            }

            .question-box,
            .btn-option {
                font-size: 1em;
            }
        }

        /* MODAL */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999;
        }

        .modal {
            background: #ffffff;
            padding: 32px;
            border-radius: 20px;
            width: 100%;
            max-width: 360px;
            text-align: center;
        }

        .modal h2 {
            color: #16a34a;
            margin-bottom: 8px;
        }

        /* MOBILE */
        @media (max-width: 640px) {
            .modal {
                max-width: calc(100% - 100px);
                margin-left: 50px;
                margin-right: 50px;
            }
        }

        .modal-score {
            font-size: 3rem;
            font-weight: 700;
            color: #16a34a;
        }

        .spinner {
            width: 18px;
            height: 18px;
            border: 3px solid rgba(255, 255, 255, 0.4);
            border-top: 3px solid #ffffff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            display: none;
            margin: 0 auto;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
    <div class="soal">
        <div class="container">
            <h2>Kuis {{$this->getKitabName()}}</h2>
            <div class="progress" id="progressText">Soal 1 dari 40</div>

            <div class="question-box" id="questionText">
                Loading...
            </div>

            <div class="answer-area" id="answerArea">
                <div class="answer-placeholder">Ketuk pilihan di bawah untuk mengurutkan</div>
            </div>

            <div class="options-area" id="optionsArea">
            </div>
            <button class="btn-next" id="resetBtn" onclick="resetSelection()" style="display:none; background:#9e9e9e;">
                Reset
            </button>
            <div class="feedback" id="feedbackMsg"></div>
            <button class="btn-next" id="nextBtn" onclick="nextQuestion()">Soal Berikutnya</button>
        </div>
    </div>
    <div id="modalSelesai" class="modal-overlay">
        <div class="modal">
            <h2>🎉 Kuis Selesai</h2>
            <p>Nilai Akhir Kamu</p>
            <div id="nilaiAkhir" class="modal-score"></div>
            <button
                id="btnSelesai"
                class="btn-finish"
                style="margin-top: 20px; position:relative;">
                <span id="btnSelesaiText">Selesai</span>
                <div id="btnSpinner" class="spinner"></div>
            </button>
        </div>
    </div>
    <script>
        const quizData = <?php echo \Illuminate\Support\Js::from($kumpulanSoal) ?>;
        const multiplierNilai = <?php echo \Illuminate\Support\Js::from($multiplierNilai) ?>;

        const soundCorrect = new Audio('/sound/correct.mp3');
        const soundWrong = new Audio('/sound/wrong.mp3');


        let jawabanBenar = 0;
        let currentQIndex = 0;
        let currentSelection = [];
        let labelMapping = {};

        const answerArea = document.getElementById('answerArea');
        const feedbackMsg = document.getElementById('feedbackMsg');
        const nextBtn = document.getElementById('nextBtn');
        const progressText = document.getElementById('progressText');
        const questionText = document.getElementById('questionText');
        const optionsArea = document.getElementById('optionsArea');
        const nilaiAkhir = document.getElementById('nilaiAkhir');
        const modalSelesai = document.getElementById('modalSelesai');
        const btnSelesai = document.getElementById('btnSelesai');
        const resetBtn = document.getElementById('resetBtn');

        const btnSpinner = document.getElementById('btnSpinner');
        const btnSelesaiText = document.getElementById('btnSelesaiText');

        btnSelesai.onclick = () => {
            const nilai = jawabanBenar * multiplierNilai;

            // Disable tombol
            btnSelesai.disabled = true;
            btnSelesaiText.style.display = 'none';
            btnSpinner.style.display = 'block';

            Livewire.dispatch('selesai-kuis', {
                nilai: nilai
            });
        };

        function createPlaceholder() {
            const div = document.createElement('div');
            div.className = 'answer-placeholder';
            div.textContent = 'Ketuk pilihan di bawah untuk mengurutkan';
            return div;
        }

        function shuffleArray(array) {
            const arr = [...array];
            for (let i = arr.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [arr[i], arr[j]] = [arr[j], arr[i]];
            }
            return arr;
        }

        function loadQuestion() {
            optionsArea.style.display = 'flex';

            labelMapping = {};
            const data = quizData[currentQIndex];
            currentSelection = [];

            answerArea.replaceChildren(createPlaceholder());
            optionsArea.replaceChildren();

            feedbackMsg.style.display = 'none';
            nextBtn.style.display = 'none';

            progressText.textContent =
                `Soal ${currentQIndex + 1} dari ${quizData.length}`;

            questionText.textContent = data.soal;

            // tampilkan jawaban (acak jika perlu)
            const shuffledJawaban = shuffleArray(data.jawaban);

            shuffledJawaban.forEach((item, index) => {
                const btn = document.createElement('div');
                btn.className = 'btn-option';
                btn.dataset.sort = item.sort; // simpan urutan benar
                btn.dataset.index = index;

                btn.onclick = () => selectOption(btn);

                const textSpan = document.createElement('span');
                textSpan.textContent = item.jawaban;

                const labelSpan = document.createElement('span');
                labelSpan.className = 'label';
                const label = String.fromCharCode(65 + index);
                labelSpan.textContent = label;

                // simpan mapping sort -> label
                labelMapping[item.sort] = label;

                btn.appendChild(textSpan);
                btn.appendChild(labelSpan);

                optionsArea.appendChild(btn);
            });
        }

        function selectOption(btn) {
            if (currentSelection.length >= 3) return;
            if (btn.style.visibility === 'hidden') return;

            currentSelection.push(parseInt(btn.dataset.sort));
            btn.style.visibility = 'hidden';

            if (currentSelection.length > 0 && currentSelection.length < quizData[currentQIndex].jawaban.length) {
                resetBtn.style.display = 'block';
            }

            if (currentSelection.length === 1) {
                answerArea.replaceChildren();
            }

            const selectedItem = btn.cloneNode(true);
            selectedItem.classList.add('selected-item');
            selectedItem.style.visibility = 'visible';
            selectedItem.onclick = null;

            answerArea.appendChild(selectedItem);

            if (currentSelection.length === 3) {
                checkAnswer();
            }
        }

        function checkAnswer() {
            resetBtn.style.display = 'none';
            optionsArea.style.display = 'none';
            const correctOrder = [...quizData[currentQIndex].jawaban]
                .sort((a, b) => a.sort - b.sort)
                .map(j => j.sort);

            const isCorrect =
                JSON.stringify(currentSelection) === JSON.stringify(correctOrder);

            feedbackMsg.style.display = 'block';

            if (isCorrect) {
                soundCorrect.currentTime = 0;
                soundCorrect.play();
                jawabanBenar++;
                feedbackMsg.className = 'feedback correct';
                feedbackMsg.textContent = 'Benar! Urutan sesuai hadis.';
            } else {
                soundWrong.currentTime = 0;
                soundWrong.play();
                feedbackMsg.className = 'feedback wrong';
                const correctLabels = correctOrder.map(sort => labelMapping[sort]);

                feedbackMsg.textContent =
                    'Kurang Tepat. Urutan Benar: ' +
                    correctLabels.join(' - ');
            }

            nextBtn.style.display = 'block';
        }

        function resetSelection() {

            // Jika sudah penuh (sudah checkAnswer), tidak boleh reset
            if (currentSelection.length === quizData[currentQIndex].jawaban.length) {
                return;
            }

            currentSelection = [];

            // Kembalikan semua opsi
            optionsArea.querySelectorAll('.btn-option').forEach(btn => {
                btn.style.visibility = 'visible';
            });

            // Reset answer area
            answerArea.replaceChildren(createPlaceholder());

            resetBtn.style.display = 'none';
        }

        function nextQuestion() {
            currentQIndex++;

            if (currentQIndex < quizData.length) {
                loadQuestion();
            } else {
                const nilai = jawabanBenar * multiplierNilai;
                nilaiAkhir.textContent = nilai;
                modalSelesai.style.display = 'flex';
            }
        }

        loadQuestion();
    </script>
</x-filament-panels::page>