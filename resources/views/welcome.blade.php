<!DOCTYPE html>
<!--//
This web page has been developed by Wani.
 - me@wani.kr
 - http://wani.kr
-->
<!--[if lt IE 7]>
<html class="ie6" lang="ko"><![endif]-->
<!--[if IE 7]>
<html class="ie7" lang="ko"><![endif]-->
<!--[if IE 8]>
<html class="ie8" lang="ko"><![endif]-->
<!--[if gt IE 8]><!-->
<html lang="ko"><!--<![endif]-->
<head>
    <title>Your Title</title>
    <meta charset="utf-8"/>

    <style>
        div.chat {
            border: 1px solid #aaa;
            width: 100%;
            height: 400px;
            overflow: scroll;
        }

        div.chat div.item + div.item {
            margin-top: 20px;
        }

        div.chat div.name {
            font-size: 14px;
            color: #999;
        }

        div.chat div.message {
            font-size: 16px;
            color: #333;
        }
    </style>
</head>
<body>

<div class="chat"></div>

<form class="form">
    <input type="text" id="name" placeholder="Name" value="손님{{ rand(0,1000) }}"/>
    <input type="text" id="message" placeholder="Your Message" autofocus/>
    <button type="submit">Send</button>
</form>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="/js/brain-socket-js/brain-socket.min.js"></script>
<script>
    (function (global, $, BrainSocket) {
        // (3-2) 앱 연결, 메시지 보내기
        var app = new BrainSocket(
                new WebSocket('ws://hashchat.app:8080'),
                new BrainSocketPubSub()
        );
        console.log(app);
        var submitMessage = function () {
            var name = $('#name').val();
            var message = $('#message').val();
            $('#message').val(''); // 폼 초기화
            app.message('send.message', {name: name, message: message});
        };
        $('form').bind('submit', function () {
            setTimeout(submitMessage, 0);
            return false;
        });

        // (3-3) 수신된 메시지 처리
        app.Event.listen('receive.message', function (msg) {
            // 본문 추가
            $('div.chat').append('<div class="item"><div class="name">' + msg.server.data.name + '</div>' +
                    '<div class="message">' + msg.server.data.message + '</div></div>');

            // 맨 아래로 스크롤 이동
            $('div.chat').scrollTop($('div.chat')[0].scrollHeight);
        });
    })(this, jQuery, BrainSocket);
</script>
</body>
</html>
