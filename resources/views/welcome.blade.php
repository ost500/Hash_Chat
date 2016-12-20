

    <div ng-repeat="message in messages"
         ng-class="{other: message.userId != myId}"
         class="messages">

        <!--<div class="message" ng-class="{'slide-right': hideTime, '': !hideTime}">-->
        <div class="message">
            <span class="msg">@{{ message.text }}</span>
        </div>




    </div>

