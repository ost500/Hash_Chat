<ion-content class="content-stable"
             on-swipe-left="hideTime = false"
             on-swipe-right="hideTime = true"
>

    <div ng-repeat="message in messages"
         ng-class="{other: message.userId != myId}"
         class="messages">

        <!--<div class="message" ng-class="{'slide-right': hideTime, '': !hideTime}">-->
        <div class="message">
            <span class="msg">{{ message.text }}</span>
        </div>

        <!--<div class="time" ng-class="{'slide-right': hideTime, '': !hideTime}">{{message.time}}</div>-->


    </div>

</ion-content>


<ion-footer-bar keyboard-attach class="bar-stable item-input-inset">
    <label class="item-input-wrapper">
        <input type="text" placeholder="Type your message" on-return="sendMessage(); closeKeyboard()"
               ng-model="data.message" on-focus="inputUp()" on-blur="inputDown()"/>
    </label>
    <button class="button button-clear" ng-click="sendMessage()">
        Send
    </button>
</ion-footer-bar>