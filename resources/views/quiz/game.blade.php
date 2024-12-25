<!-- 共通レイアウトを継承して表示組み立て -->
@extends('quiz._layout')

@section('title', $region . 'の' . $category . 'クイズ')

@section('content')
<div class="quiz-game-container">
    <h1 class="game-title">{{ $region }}の{{ $category }}クイズ</h1>

    <div class="quiz-content">
        <!-- 問題表示エリア -->
        <div id="question-display" class="question-area"></div>
        
        <!-- 選択肢表示エリア -->
        <div id="options-container" class="options-area"></div>

        <!-- フィードバック表示エリア -->
        <div id="feedback-area" class="feedback-area hidden">
            <div id="result-message"></div>
            <div id="explanation" class="explanation"></div>
            <button id="next-button" class="next-button">
                次の問題へ
            </button>
        </div>
    </div>
</div>
@endsection

@section('additional_css')
<style>
    .quiz-game-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .game-title {
        color: white;
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: center;
    }

    .quiz-content {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .question-area {
        font-size: 1.25rem;
        margin-bottom: 30px;
        color: var(--navy-color);
        font-weight: bold;
    }

    .options-area {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .option-button {
        padding: 15px 20px;
        border: 2px solid var(--main-color);
        border-radius: 8px;
        background: white;
        color: var(--navy-color);
        font-size: 1rem;
        text-align: left;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .option-button:hover {
        background-color: var(--light-color);
    }

    .option-button:disabled {
        cursor: not-allowed;
        opacity: 0.7;
    }

    .feedback-area {
        margin-top: 20px;
        padding: 20px;
        border-radius: 8px;
    }

    .feedback-area.correct {
        background-color: #E8F5E9;
        border: 1px solid #81C784;
    }

    .feedback-area.incorrect {
        background-color: #FFEBEE;
        border: 1px solid #E57373;
    }

    .explanation {
        margin-top: 15px;
        font-size: 0.95rem;
        color: var(--navy-color);
    }

    .next-button {
        display: block;
        width: 200px;
        margin: 20px auto 0;
        padding: 12px 24px;
        background-color: var(--main-color);
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .next-button:hover {
        background-color: var(--navy-color);
    }

    .hidden {
        display: none;
    }
</style>
@endsection

@section('additional_js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quizzes = @json($quizzes);
        let currentQuestionIndex = 0;

        function displayQuestion() {
            console.log('Current index:', currentQuestionIndex);
            console.log('Quizzes array:', quizzes);
            
            if (currentQuestionIndex >= quizzes.length) {
                console.error('Quiz index out of bounds');
                window.location.href = '{{ route("quiz.result") }}';
                return;
            }
            
            const quiz = quizzes[currentQuestionIndex];
            console.log('Current quiz:', quiz);
            
            // 問題文の表示
            document.getElementById('question-display').textContent = quiz.question;
            
            // 選択肢の表示
            const optionsContainer = document.getElementById('options-container');
            optionsContainer.innerHTML = '';
            
            quiz.options.forEach(option => {
                const button = document.createElement('button');
                button.className = 'option-button';
                button.textContent = option.option_text;
                button.onclick = () => submitAnswer(quiz.id, option.id);
                optionsContainer.appendChild(button);
            });

            // フィードバックエリアを隠す
            document.getElementById('feedback-area').className = 'feedback-area hidden';
        }

        async function submitAnswer(quizId, answerId) {
            console.log('Submitting answer:', { quizId, answerId });
            try {
                const response = await fetch('{{ route("quiz.submit-answer") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ quiz_id: quizId, answer_id: answerId })
                });
                
                console.log('Response:', response);
                const result = await response.json();
                console.log('Result:', result);
                
                showFeedback(result);
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function showFeedback(result) {
            console.log('Feedback result:', result);
            console.log('Current question index:', currentQuestionIndex);
            console.log('Total questions:', quizzes.length);
            
            const feedbackArea = document.getElementById('feedback-area');
            feedbackArea.className = `feedback-area ${result.result.is_correct ? 'correct' : 'incorrect'}`;
            
            document.getElementById('result-message').textContent = 
                result.result.is_correct ? '正解！' : '不正解...';
            document.getElementById('explanation').textContent = result.result.explanation;
            
            feedbackArea.classList.remove('hidden');

            // 次の問題へのボタンの処理
            const nextButton = document.getElementById('next-button');
            nextButton.onclick = () => {
                if (result.is_last_question) {
                    window.location.href = '{{ route("quiz.result") }}';
                } else {
                    currentQuestionIndex++;
                    displayQuestion();
                }
            };
        }

        // 最初の問題を表示
        displayQuestion();
    });
</script>
@endsection