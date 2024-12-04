<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,600;1,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/assets/css/chat.css') }}">
    <link rel="stylesheet" href="{{ asset('template/style.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/css/typing.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * {
            font-size: 10px;
        }

        .typing-animation::after {
            content: '';
            display: inline-block;
            width: 8px;
            height: 14px;
            margin-left: 4px;
            background-color: #333;
            animation: blink 0.8s infinite;
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }

        #rating-icons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .feedback-icon {
            font-size: 24px;
            cursor: pointer;
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        .feedback-icon:hover {
            color: #E0E0E0;
        }

        .feedback-icon.selected {
            background-color: #E0E0E0;
            color: white;
        }

        #selected-rating {
            display: none;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .gif-animation {
            display: none;
            animation: fadeIn 3s ease-out;
        }

        .chatbox__gif-container {
            text-align: center;
            margin-top: 20px;
        }

        .messages__item__error {
            font-size: 13px;
            color: red;
            overflow: hidden;
        }

        .typed-text {
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            border-right: 2px solid #000;
            animation: typing 7s steps(40) infinite;
        }

        @keyframes typing {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }
    </style>

    <title>Chatbot by Farhan</title>
</head>

<body>
    <audio id="operatorMessageSound">
        <source src="{{ asset('sound/visitor.mp3') }}" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>
    <audio id="visitorMessageSound">
        <source src="{{ asset('sound/operator.mp3') }}" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>

    <div class="container">
        <div class="chatbox">
            @if (session('name') && session('nip'))
                <div class="chatbox__support bot chatbox--active">
                    <div class="chatbox__header">
                        <div class="chatbox__content--header">
                            <h4 class="chatbox__heading--header" style="text-transform: uppercase;">KEVAS (Kanmo
                                employee
                                virtual assistance)
                            </h4>
                            <p class="chatbox__description--header" style="text-transform: uppercase;">Logged as
                                {{ session('name') }}</p>
                            <p class="chatbox__description--header">
                                <button onclick="toggleChatSection('myBot')"
                                    style="padding: 5px; border-radius: 5px; background: #E0E0E0; color: black; border: none; text-transform: uppercase;">
                                    Bot</button>
                                <button onclick="toggleChatSection('myFeedBack')"
                                    style="padding: 5px; border-radius: 5px; background: #E0E0E0; color: black; border: none; text-transform: uppercase;">End
                                    Session
                                </button>
                            </p>
                        </div>
                    </div>
                    <div class="chatbox__messages myElement myBot">
                        <div id="chatMessages">
                        </div>
                    </div>
                    <div class="myElement myBotS">
                        <form id="chatForm">
                            @csrf
                            <div class="chatbox__footer__select" id="questionSection" style="margin-top: 15px;">
                                <select name="user_question" id="user_question"
                                    style="width: 233px; padding: 5px; border-radius: 20px; font-size: 10px;" required>
                                    @foreach ($questions as $item)
                                        <option value="{{ $item->question }}">{{ $item->question }} -
                                            {{ $item->category }}</option>
                                    @endforeach
                                </select>
                                <button type="button" id="sendButton" class="chatbox__send--footer">Send</button>
                            </div>
                        </form>
                        <div class="chatbox__footer" style="margin-top: -10px;">
                            <button onclick="toggleChatSection('myAnother')"
                                style="padding: 8px; border-radius: 5px; background: #E0E0E0; color: black; border: none; text-transform: uppercase;">
                                Free Text Question</button>
                        </div>
                    </div>
                    <div class="chatbox__messages myElement myFeedBack" style="display: none;">
                        <div>
                            <div class="chatbox__footer"
                                style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 0px; border-bottom-right-radius: 0px; color: white; font-size: 15px; text-align: center; justify-content: center;">
                                Thank you for your question 😊.
                            </div>

                            <form id="submitFeedbackForm" action="{{ route('saveUserAndFeedback') }}" method="post">
                                @csrf

                                <div class="chatbox__footer" style="border-radius: 0; margin-bottom: -10px;">
                                    <p
                                        style="width: 280px; text-transform: uppercase; color: white; text-align: center; justify-content: center;">
                                        Please rate our service by click below icon
                                    </p>
                                </div>

                                <div class="chatbox__footer"
                                    style="border-radius: 0; margin-bottom: -10px; text-align: center;justify-content: center;">
                                    <div id="rating-icons">
                                        <span class="feedback-icon" data-rating="3">😍</span>
                                        <span class="feedback-icon" data-rating="2">😐</span>
                                        <span class="feedback-icon" data-rating="1">😞</span>
                                    </div>
                                    <input type="hidden" name="rating" id="selected-rating" required>
                                </div>

                                <div class="chatbox__footer" style="border-radius: 0; margin-bottom: -10px;">
                                    <input type="text" name="feedback" placeholder="Write your feedback..."
                                        style="width: 280px; text-transform: uppercase;">
                                </div>

                                <div class="chatbox__footer"
                                    style="text-align: center; border-top-right-radius: 0px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; padding: 10px; text-align:center; justify-content: center;">
                                    <!-- Ganti id tombol submit -->
                                    <button type="submit" id="submitFeedbackButton"
                                        class="chatbox__send--footer">Logout</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="chatbox__footer myElement myFeedBacks"
                        style="margin-top: 10px; padding: 20px; color: white; text-align:center; justify-content: center; display: none;">
                        Powered by Kanmo Group.
                    </div>
                    <div class="chatbox__messages  myElement myAnother" style="display: none;">
                        <div id="chatMessagesQuestions">
                        </div>
                    </div>
                    <form id="chatFormQuestion" class="myElement myAnothers" style="display: none; margin-top: 15px;">
                        @csrf
                        <div class="chatbox__footer" id="question_another">
                            <input type="text" name="user_question" id="user_question_another"
                                style="width: 280px; padding: 10px; border-radius: 20px; font-size: 10px; text-transform: uppercase;"
                                required placeholder="Input your free text question..">
                            <button type="button" id="sendButtonQuestion"
                                class="chatbox__send--footer">Send</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="chatbox__support chatbox--active gif-animation">
                    <div class="chatbox__header">
                        <div class="chatbox__content--header">
                            <h4 class="chatbox__heading--header"
                                style="text-transform: uppercase; font-size: 13px!important;">KEVAS <br>(Kanmo employee
                                virtual assistance)
                            </h4>
                        </div>
                    </div>
                    @if (session('error'))
                        <div class="chatbox__messages" style="margin-bottom: -26px;">
                            <div id="app">
                                <div class="messages__item messages__item__error messages__item--visitor">
                                    <span class="typed-text" style="font-size: 13px;"></span>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="chatbox__gif-container">
                        <img src="{{ asset('chatbot/bot.gif') }}" alt="Bot Animation" width="300px"
                            height="280px">
                        <button id="startButton" class="chatbox__send--footer" style="text-transform: uppercase;">Ask
                            me</button>
                    </div>
                </div>
                <div class="chatbox__support chatbox--active" id="formContainer" style="display: none;">
                    <div class="chatbox__header">
                        <div class="chatbox__content--header">
                            <h4 class="chatbox__heading--header"
                                style="text-transform: uppercase; font-size: 13px!important;">KEVAS
                            </h4>
                        </div>
                    </div>
                    <div class="chatbox__messages">
                        <div>
                            <div class="chatbox__footer"
                                style="border-top-left-radius: 20px; border-top-right-radius: 20px; border-bottom-left-radius: 0px; border-bottom-right-radius: 0px; padding: 12px; color: white; font-size: 11px; text-align: center;">
                                Hello and welcome to Kanmo employee
                                virtual assistance! <br>How may I help you?
                            </div>
                            <form action="{{ route('saveUserAndQuestion') }}" method="post">
                                @csrf
                                <div class="chatbox__footer" style="border-radius: 0;; padding: 12px;">
                                    <input type="text" name="name" placeholder="Write a name..." required
                                        style="width: 280px; text-transform: uppercase;">
                                </div>
                                <div class="chatbox__footer" style="border-radius: 0; padding: 10px;">
                                    <input type="number" name="nip" placeholder="Write a nip..." required
                                        style="width: 280px; text-transform: uppercase;">
                                </div>
                                <div class="chatbox__footer"
                                    style="text-align: center                                    ; border-top-right-radius: 0px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; padding: 10px; text-align:center; justify-content: center;">
                                    <button type="submit" class="chatbox__send--footer"
                                        style="text-transform: uppercase;">Start</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="chatbox__footer"
                        style="margin-top: 10px; padding: 20px; color: white; text-align:center; justify-content: center;">
                        Powered by Kanmo Group.
                    </div>
                </div>
            @endif
            {{-- <div class="chatbox__button">
                <button>button</button>
            </div> --}}
        </div>
    </div>
    <!-- jQuery and other scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />

    <script src="{{ asset('template/assets/js/Chat.js') }}"></script>
    <script src="{{ asset('template/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.gif-animation').fadeIn(500);

            $('#startButton').on('click', function() {
                $('.gif-animation').fadeOut(500, function() {
                    $('#formContainer').fadeIn();
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#user_question').select2({
                width: '280px',
                placeholder: 'Select Question',
                allowClear: true
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var errorText = "{{ session('error') }}";

            $('.typed-text').text(errorText);
        });
    </script>

    <script>
        $(document).ready(function() {
            var chatHistoryData;
            var inactivityTimer;
            var feedbackTimer;

            function loadChatHistory() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('getChatHistory') }}',
                    dataType: 'json',
                    success: function(data) {
                        chatHistoryData = data;
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }

            function displayChatHistory() {
                $('#chatMessages').html('');
                $.each(chatHistoryData.history, function(index, response) {
                    if (response.question && response.question.question !== null && response.question
                        .answer !== null) {
                        var question = response.question.question;
                        var answer = response.question.answer;

                        $('#chatMessages').append(
                            '<div class="messages__item messages__item--operator" style="font-size: 10px; text-align: right;">' +
                            question +
                            '<p style="font-size: 8px; text-align: right;">' +
                            formatDateTime(response.created_at) +
                            ' WIB</p>' +
                            '</div>' +
                            '<div class="messages__item messages__item--visitor" style="font-size: 10px;">' +
                            answer +
                            '<p style="font-size: 8px;">' +
                            formatDateTime(response.created_at) +
                            ' WIB</p>' +
                            '</div>'
                        );
                    }
                });

                $('#chatMessages').show();
            }

            loadChatHistory();

            var viewHistoryButton =
                '<div id="viewHistoryButton" style="text-align: center; justify-content: center; align-items: center;">' +
                '<div class="messages__item messages__item--visitor" style="font-size: 10px; margin-bottom: 10px;">How can I help you today?</div>' +
                '<button type="button" class="chatbox__send--footer" style="width: 320px; background: #e0e0e0; border-radius: 20px;">View History</button>' +
                '</div>';
            $('#chatMessages').after(viewHistoryButton);

            $(document).on('click', '#viewHistoryButton', function() {
                displayChatHistory();
                $(this).hide();
            });

            function startInactivityTimer() {
                inactivityTimer = setTimeout(function() {
                    redirectToFeedbackSection();
                }, 30000);
            }

            function resetInactivityTimer() {
                clearTimeout(inactivityTimer);
                startInactivityTimer();
            }

            function startFeedbackTimer() {
                feedbackTimer = setTimeout(function() {
                    selectRatingAndSubmit(3);
                }, 5000);
            }

            function resetFeedbackTimer() {
                clearTimeout(feedbackTimer);
                startFeedbackTimer();
            }

            function redirectToFeedbackSection() {
                toggleChatSection('myFeedBack');
                startFeedbackTimer();
            }

            function checkForNewSession() {
                var savedData = JSON.parse(sessionStorage.getItem('savedData'));

                if (savedData) {
                    var lastPostTime = new Date(savedData.latestResponse.created_at).getTime();
                    var currentTime = new Date().getTime();
                    var timeDifference = currentTime - lastPostTime;

                    if (timeDifference >= 30000) {
                        redirectToFeedbackSection();
                    }
                }
            }

            function selectRatingAndSubmit(rating) {
                document.getElementById("selected-rating").value = rating;

                var selectedIcon = document.querySelector('.feedback-icon[data-rating="' + rating + '"]');
                if (selectedIcon) {
                    selectedIcon.classList.add('selected');
                }

                submitFeedbackForm();
            }

            function submitFeedbackForm() {
                document.querySelector('#submitFeedbackButton').click();
            }

            var checkSessionInterval = setInterval(checkForNewSession, 30000);

            $('#sendButton').click(function() {
                resetInactivityTimer();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('saveUserAndQuestion') }}',
                    data: $('#chatForm').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        var question = data.question ? data.question : '';
                        var answer = data.question ? data.answer : '';

                        $('#chatMessages').show();

                        if (data.latestResponse) {
                            $('#chatMessages').append(
                                '<div class="messages__item messages__item--operator" style="font-size: 10px; text-align: right;">' +
                                question +
                                '<p style="font-size: 8px; text-align: right;">' +
                                formatDateTime(data.latestResponse.created_at) +
                                ' WIB</p>' +
                                '</div>'
                            );

                            $('#chatMessages').append(
                                '<div class="messages__item messages__item--visitor typing-animation" style="font-size: 10px;">Typing...</div>'
                            );

                            playMessageSound('visitor');

                            setTimeout(function() {
                                $('.typing-animation').remove();

                                playMessageSound('operator');

                                $('#chatMessages').append(
                                    '<div class="messages__item messages__item--visitor" style="font-size: 10px;">' +
                                    answer +
                                    '<p style="font-size: 8px;">' +
                                    formatDateTime(data.latestResponse.created_at) +
                                    ' WIB</p>' +
                                    '</div>');
                            }, 3000);
                        } else {
                            console.log('No latest response data available.');
                        }

                        sessionStorage.setItem('savedData', JSON.stringify(data));
                        stopCheckSessionInterval();
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

            function stopCheckSessionInterval() {
                clearInterval(checkSessionInterval);
            }

            function formatDateTime(dateTimeString) {
                var options = {
                    hour: 'numeric',
                    minute: 'numeric'
                };
                var formattedDate = new Date(dateTimeString).toLocaleDateString('id-ID', options);
                return formattedDate;
            }

            function playMessageSound(userType) {
                var audio;
                if (userType === 'operator') {
                    audio = document.getElementById('operatorMessageSound');
                } else if (userType === 'visitor') {
                    audio = document.getElementById('visitorMessageSound');
                }

                if (audio) {
                    audio.play();
                }
            }

            startInactivityTimer();
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#sendButtonQuestion').click(function() {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('saveUserAndQuestionAnother') }}',
                    data: $('#chatFormQuestion').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        var questionText = data.question ? data.question.question : '';
                        var created_at = data.question ? data.question.created_at : '';

                        $('#chatMessagesQuestions').append(
                            '<div class="messages__item messages__item--operator" style="font-size: 10px; text-align: right;">' +
                            questionText +
                            '<p style="font-size: 8px; text-align: right;">' +
                            formatDateTime(created_at) +
                            ' WIB</p>' +
                            '</div>'
                        );

                        $('#chatMessagesQuestions').append(
                            '<div class="messages__item messages__item--visitor typing-animation" style="font-size: 10px;">Typing...</div>'
                        );

                        playMessageSound('visitor');

                        $('#user_question_another').val('');

                        setTimeout(function() {
                            $('.typing-animation').remove();

                            playMessageSound('operator');

                            $('#chatMessagesQuestions').append(
                                '<div class="messages__item messages__item--visitor" style="font-size: 10px;">' +
                                'Terimakasih atas pertanyaannya, dalam tahap perkembangan maka kita akan terus mereview semua pertanyaan yang belum kita data di dalam sistem atau dapat mengirimkan email ke hrbp@kanmogroup.com untuk response cepat 😊.' +
                                '<p style="font-size: 8px;">' +
                                formatDateTime(created_at) +
                                ' WIB</p>' +
                                '</div>'
                            );
                        }, 3000);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });

        function formatDateTime(dateTimeString) {
            var options = {
                hour: 'numeric',
                minute: 'numeric'
            };
            var formattedDate = new Date(dateTimeString).toLocaleDateString('id-ID', options);
            return formattedDate;
        }

        function playMessageSound(userType) {
            var audio;
            if (userType === 'operator') {
                audio = document.getElementById('operatorMessageSound');
            } else if (userType === 'visitor') {
                audio = document.getElementById('visitorMessageSound');
            }

            if (audio) {
                audio.play();
            }
        }
    </script>

    <script>
        function toggleChatSection(section) {
            var myBotElement = document.querySelector('.myBot');
            var myBotSElement = document.querySelector('.myBotS');
            var myFeedBackElement = document.querySelector('.myFeedBack');
            var myFeedBacksElement = document.querySelector('.myFeedBacks');
            var myAnotherElement = document.querySelector('.myAnother');
            var myAnothersElement = document.querySelector('.myAnothers');

            myBotElement.style.display = (section === 'myBot') ? 'block' : 'none';
            myBotSElement.style.display = (section === 'myBot') ? 'block' : 'none';
            myFeedBackElement.style.display = (section === 'myFeedBack') ? 'block' : 'none';
            myFeedBacksElement.style.display = (section === 'myFeedBack') ? 'block' : 'none';
            myAnotherElement.style.display = (section === 'myAnother') ? 'block' : 'none';
            myAnothersElement.style.display = (section === 'myAnother') ? 'block' : 'none';

            document.querySelector('button').textContent;
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const feedbackIcons = document.querySelectorAll(".feedback-icon");

            feedbackIcons.forEach(function(icon) {
                icon.addEventListener("click", function() {
                    const selectedRating = this.getAttribute("data-rating");
                    document.getElementById("selected-rating").value = selectedRating;

                    feedbackIcons.forEach(function(icon) {
                        icon.classList.remove("selected");
                    });
                    this.classList.add("selected");
                });
            });
        });
    </script>
</body>

</html>
