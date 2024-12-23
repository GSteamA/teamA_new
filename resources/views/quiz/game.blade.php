<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>クイズ - {{$region}}</title>
    @vite(['public/css/quiz/game.css','public/js/quiz/game.js'])
</head>
<body>
    <div>
        <h1>{{ $region }} - {{ $category }}</h1>

        <div>
            <div id="question-display"></div>
            <div id="options-container"></div>
            <div id="result-feedback"></div>
        </div>
    </div>
    
    <script>
        // クイズデータをJavaScriptで利用できるように
        const quizzes = @json($gameConfig['quizzes']);
        let currentQuestionIndex = 0;

        function displayQuestion() {
            const quiz = quizzes[currentQuestionIndex];
            document.getElementById('question-display').innerHTML = `
                <h2 class="text-xl font-semibold mb-4">${quiz.question}</h2>
            `;

            const optionsHtml = quiz.options.map(option => `
                <button onclick="submitAnswer(${quiz.id}, ${option.id})" 
                        class="block w-full text-left p-4 mb-2 bg-gray-50 rounded hover:bg-gray-100">
                    ${option.option_text}
                </button>
            `).join('');

            document.getElementById('options-container').innerHTML = optionsHtml;
        }

        async function submitAnswer(quizId, optionId) {
            try {
                const response = await fetch('/quiz/submit-answer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ quiz_id: quizId, answer_id: optionId })
                });

                const result = await response.json();
                
                if (result.is_last_question) {
                    window.location.href = '/quiz/result';
                } else {
                    currentQuestionIndex++;
                    displayQuestion();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // 最初の問題を表示
        displayQuestion();
    </script>
</body>
</html>