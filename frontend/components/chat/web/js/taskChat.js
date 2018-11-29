$(function () {
  'use strict';


  let taskId = $('#chatmessages-task_id').val();
  if (!Number.isNaN(Number.parseInt(taskId))) {

    let scrollDown = function (elem) {
      elem.scrollTo(0, elem.scrollHeight);
    };

    let chatBox = document.getElementById('messages_items');
    scrollDown(chatBox);

    let form = $('#taskChat');
    let submitBtn = form.find('[type=submit]');
    let connected = $('#chat-connected');
    let url = 'ws://' + document.location.hostname + ':8080?' + taskId;
    let ws = new WebSocket(url);
    ws.onopen = function () {
      submitBtn.prop('disabled', false);
      connected.text('Connected')
    };
    ws.onclose = function (event) {
      submitBtn.prop('disabled', true);
      connected.text('Disconnected');
      console.log('close: ' + event.code)
    };
    ws.onmessage = function (event) {
      let data = JSON.parse(event.data);
      renderChatItem(data);
      scrollDown(chatBox);
    };

    form.on('beforeSubmit', function () {
      ws.send($(this).serialize());
      this.reset();
      return false;
    });

    let getTemplateChatItem = function () {
      return $(
        '<div class="direct-chat-msg right">' +
        '<div class="direct-chat-info clearfix">' +
        '<div id="fullName" class="direct-chat-name pull-left"></div>' +
        '<div id="createDate" class="direct-chat-timestamp pull-right"></div>' +
        '</div>' +
        '<div id="message" class="direct-chat-text"></div>' +
        '</div>'
      );
    };

    let renderChatItem = function (message) {
      let chatItem = getTemplateChatItem();

      chatItem.find('#fullName').text(message.fullName);
      chatItem.find('#createDate').text(message.created);
      chatItem.find('#message').text(message.ChatMessages.message);
      chatItem.appendTo($('#messages_items'));
    };
  }
});