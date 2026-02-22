<?php
$kumpulanSoal =  $this->GetSoal();
$multiplierNilai = 5;
// [{"id":1,"hadits_id":1,"tipe":"pemahaman","soal":"Apalahh","media":null,"created_at":"2026-01-06T15:35:22.000000Z","updated_at":"2026-01-11T07:14:44.000000Z","kitab_id":1,"bab_id":1}]
?>
<x-filament-panels::page>

    <style>
        <?php
        if (auth()->user()?->role === 'siswa') {
        ?>.fi-topbar-open-sidebar-btn {
            display: none !important;
        }

        <?php
        }
        ?>
    </style>
    <style>
        .quiz-wrapper {
            display: flex;
            justify-content: center;
            padding: 1rem;
        }

        .quiz-card {
            width: 100%;
            max-width: 700px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
            padding: 24px;
        }

        .quiz-number {
            color: #16a34a;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .quiz-question {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .quiz-petunjuk {
            border-left: 4px solid #22c55e;
            font-size: 1rem;
            margin-bottom: 20px;
            padding: 20px;
        }

        .quiz-answers {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .answer-btn {
            padding: 14px 18px;
            border-radius: 999px;
            border: 2px solid #d1d5db;
            background: #ffffff;
            cursor: pointer;
            text-align: left;
            transition: all .2s ease;
            font-size: .95rem;
        }

        .answer-btn:hover {
            background: #f0fdf4;
        }

        .answer-btn:disabled {
            cursor: default;
            opacity: .9;
        }

        .answer-correct {
            background: #bbf7d0;
            border-color: #15803d;
        }

        .answer-wrong {
            background: #fecaca;
            border-color: #b91c1c;
        }

        .btn-next {
            margin-top: 24px;
            padding: 14px;
            width: 100%;
            border-radius: 999px;
            border: none;
            background: #16a34a;
            color: #ffffff;
            font-weight: 600;
            cursor: pointer;
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
            background: #15803d;
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

        /* PARTICLE */
        .particle {
            position: fixed;
            font-size: 20px;
            pointer-events: none;
            animation: particle-fall 900ms ease-out forwards;
            z-index: 9999;
        }

        @keyframes particle-fall {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 1;
            }

            100% {
                transform: translate(var(--x), var(--y)) scale(0.5);
                opacity: 0;
            }
        }
    </style>

    <div class="quiz-wrapper">
        <div class="quiz-card">

            <div class="quiz-number">
                Soal <span id="nomorSoal">1</span> / {{ $kumpulanSoal->count() }}
            </div>

            <div id="soalText" class="quiz-question"></div>
            <div id="petunjukText" class="quiz-petunjuk"></div>

            <div id="jawabanContainer" class="quiz-answers"></div>

            <button id="btnLanjut" class="btn-next">
                Lanjut
            </button>

        </div>
    </div>

    {{-- MODAL --}}
    <div id="modalSelesai" class="modal-overlay">
        <div class="modal">
            <h2>🎉 Kuis Selesai</h2>
            <p>Nilai Akhir Kamu</p>
            <div id="nilaiAkhir" class="modal-score"></div>
            <button
                id="btnSelesai"
                class="btn-finish"
                style="margin-top: 20px;">
                Selesai
            </button>
        </div>
    </div>

    {{-- Inject Data --}}
    <script>
        const soalData = <?php echo \Illuminate\Support\Js::from($kumpulanSoal) ?>;
        const multiplierNilai = <?php echo \Illuminate\Support\Js::from($multiplierNilai) ?>;
        const soundCorrect = new Audio('/sound/correct.mp3');
        const soundWrong = new Audio('/sound/wrong.mp3');

        // optional: kecilkan volume
        soundCorrect.volume = 0.6;
        soundWrong.volume = 0.6;
    </script>

    <script>
        let indexSoal = 0;
        let jawabanBenar = 0;
        let sudahMenjawab = false;

        const soalText = document.getElementById('soalText');
        const petunjukText = document.getElementById('petunjukText');
        const jawabanContainer = document.getElementById('jawabanContainer');
        const btnLanjut = document.getElementById('btnLanjut');
        const nomorSoal = document.getElementById('nomorSoal');
        const modalSelesai = document.getElementById('modalSelesai');
        const btnSelesai = document.getElementById('btnSelesai');

        btnSelesai.onclick = () => {
            const nilai = jawabanBenar * multiplierNilai;
            const kuisIndex = window.kuisIndex;

            // Panggil method Livewire Page
            Livewire.dispatch('selesai-kuis', {
                nilai: nilai
            });
        };


        function tampilSoal() {
            sudahMenjawab = false;
            btnLanjut.style.display = 'none';
            jawabanContainer.innerHTML = '';

            const soal = soalData[indexSoal];
            nomorSoal.innerText = indexSoal + 1;
            soalText.innerHTML = soal.soal;
            petunjukText.innerHTML = 'Petunjuk: ' + soal.petunjuk;

            soal.jawaban.forEach(j => {
                const btn = document.createElement('button');
                btn.className = 'answer-btn';
                btn.innerText = j.jawaban;
                btn.onclick = (e) => pilihJawaban(btn, j.benar, e);
                jawabanContainer.appendChild(btn);
            });
        }

        function pilihJawaban(btn, benar, event) {
            if (sudahMenjawab) return;
            sudahMenjawab = true;

            const x = event.clientX;
            const y = event.clientY;

            const semuaButton = jawabanContainer.querySelectorAll('button');

            semuaButton.forEach(b => b.disabled = true);

            if (benar) {
                btn.classList.add('answer-correct');
                jawabanBenar++;

                soundCorrect.currentTime = 0;
                soundCorrect.play();

                spawnParticles(x, y, '⭐');
            } else {
                btn.classList.add('answer-wrong');

                // 🔥 TAMBAHAN: tampilkan jawaban yang benar
                soalData[indexSoal].jawaban.forEach((j, i) => {
                    if (j.benar) {
                        semuaButton[i].classList.add('answer-correct');
                    }
                });

                soundWrong.currentTime = 0;
                soundWrong.play();

                spawnParticles(x, y, '😭');
            }

            btnLanjut.style.display = 'block';
        }


        btnLanjut.onclick = () => {
            indexSoal++;

            if (indexSoal < soalData.length) {
                tampilSoal();
            } else {
                const nilai = jawabanBenar * multiplierNilai;
                document.getElementById('nilaiAkhir').innerText = nilai;
                modalSelesai.style.display = 'flex';
            }
        };

        function spawnParticles(x, y, emoji) {
            for (let i = 0; i < 14; i++) {
                const particle = document.createElement('span');
                particle.className = 'particle';
                particle.innerText = emoji;

                const offsetX = (Math.random() - 0.5) * 120;
                const offsetY = Math.random() * -120;

                particle.style.left = x + 'px';
                particle.style.top = y + 'px';
                particle.style.setProperty('--x', offsetX + 'px');
                particle.style.setProperty('--y', offsetY + 'px');

                document.body.appendChild(particle);

                setTimeout(() => particle.remove(), 900);
            }
        }


        tampilSoal();
    </script>

</x-filament-panels::page>
<!---- Sound Effect by Sophia Conçeição from Pixabay --->
<!----  Sound Effect by Universfield from Pixabay --->