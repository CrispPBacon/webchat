$(document).ready(function() {
    
    let oldData = '';
    let newData = '';
    let oldArray = '';
    let curr_friends_ids;
    let oldSearch = '';

    function isJSON(str) {
        try {
            JSON.parse(str);
            return true;
        } catch (e) {
            return false;
        }
    }
    
    const chat_list_interval = setInterval(fetch_chatlist_history, 700);
    function fetch_chatlist_history() {
        curr_friends_ids = [];
        if ($('#forchat-content').length) {
            $.ajax({
                url: 'backend/chat/chatmain_backend.php',
                method: 'post',
                data: {
                    request: 'fetch_chatlist_history',
                },
                success: function(data) {
                    if (!isJSON(data)) {
                        console.log(data);
                        return
                    }
                    if (data == oldArray) {
                        return
                    }
                    oldArray = data;
                    const info = JSON.parse(data);
                    const friends_information = info.friends_info;
                    const userId = info.userid;
                    let content = '';
                    for(const details of friends_information) {
                        const msg_date = details.date;
                        const name = details['friendUid'];
                        const friendId = details['friendId'];
                        const senderId = details.sender_id;
                        const message = details['message']
                        const message_status = senderId == userId ? 'READ' : details['message_status'];
                        const weight = message_status == 'UNREAD' ? 'bold' : 'unset';
                        const status = message_status == 'UNREAD' ? "<ion-icon name='ellipse' style='font-size: .3rem;'></ion-icon>" : "<ion-icon name='checkmark-done'></ion-icon>";
                        const start = msg_date.indexOf(' ')+1;
                        let hrs = msg_date.slice(start, msg_date.indexOf(':'));
                        const mins = msg_date.slice(msg_date.indexOf(':')+1, msg_date.indexOf(':')+3);
                        // const secs = msg_date.slice(msg_date.indexOf(':')+4);
                        let time = "AM";
                        if (hrs == '00') {
                            hrs = 12;
                        }
                        if (hrs > 12) {
                            hrs = hrs-12;
                            time = "PM";
                        }
                        content += `
                        <span id='chat_id_${friendId}'>
                            <img src='images/john-doe.jpg' alt='john-doe'>
                            <div class='details' style='font-weight:${weight};'>
                                <div class='name'>
                                    <h3 style='font-weight:${weight};'>${name}</h3>
                                    <div>
                                    ${status}
                                    <chat>${message}</chat>
                                    </div>
                                </div>
                                <time>${hrs}:${mins} ${time}</time>
                            </div>
                        </span>          
                        `;

                        const isSender = senderId == userId;
                        curr_friends_ids["s"+friendId] = isSender;
                        
                        // console.log(msg_date + " /// " + `${hrs}:${mins}:${secs} ${time}`);
                    }

                    newData = content;
                    if (newData != oldData) {
                        oldData = newData;
                        $('#forchat-content').html(content);
                        for(const key in curr_friends_ids) {
                            const friend_id = key.slice(1);
                            const is_sender = curr_friends_ids[key];
                            $('#chat_id_'+friend_id).click(function() {
                                open_chat_id(friend_id, is_sender);
                            });
                        }
                    }
                    
                },
            });
        }
        
        const search_result = $('#search_result');
        if (Boolean($('#search_input').val().trim())) {
            const search_input = $('#search_input').val().trim();
            $.ajax({
                url: 'backend/chat/chatmain_backend.php',
                method: 'post',
                data: { request: 'get_search_profiles', search_data: search_input },
                success: function(data) {
                    if (!isJSON(data)) {
                        return;
                    }
                    if (oldSearch == data) {
                        return
                    }
                    oldSearch = data;
                    const result = JSON.parse(data);
                    let content = '';
                    for (const detail of result) {
                        const Uid = detail.friendUid;
                        const Id = detail.friendId;
                        content += `<li id="search_id${Id}">${Uid}#${Id}</li>`;
                    }
                    search_result.html(content);
                    for (const detail of result) {
                        const Id = detail.friendId;
                        $(`#search_id${Id}`).click(function() { open_chat_id(Id, true); });
                    }
                }
            });
        } else {
            search_result.html('');
        }
        
    }

    function open_chat_id(friend_id, is_sender) {
        if (!is_sender) {
            $.ajax({
                url: 'backend/chat/chatmain_backend.php',
                method: 'post',
                data: { request: 'set_read_status', friend_id: friend_id },
            });
        }

        $.ajax({
            url: 'ajax/chatbox.php',
            success: function(data) {
                $('body').html(data);
                $('#chatbox_id_load').html(`<input type="text" disabled id="id_loader" value="${friend_id}">`);
            }
        });
        $.ajax({
            url: 'backend/chat/chatmain_backend.php',
            method: 'post',
            data: {request: 'fetch_chatbox_details', friend_id: friend_id},
            success: function(data) {
                if (!isJSON(data)) {
                    return;
                }
                const details = JSON.parse(data);
                friend_name = details['usersUid']
                $('#profile_name').html(friend_name);
            }
        });
        clearInterval(chat_list_interval);
    }
    
    const search_btn = $('#search_btn');
    const search_field = $('#search_field');
    const search_input = $('#search_input');
    const clear_btn = $('#clear_btn');

    search_btn.mouseenter(function() {
        search_btn.toggleClass('hidden');
        search_field.toggleClass('active');
        search_input.focus();
    });

    search_input.mouseenter(function() {
        search_input.focus();
    });

    search_btn.click(function() {
        search_btn.toggleClass('hidden');
        search_field.toggleClass('active');
    });

    search_field.mouseleave(function() {
        // console.log(Boolean(search_input.val()));
        if (!Boolean(search_input.val().trim())) {
            search_btn.toggleClass('hidden');
            search_field.toggleClass('active');
        }
    });

    clear_btn.click(function() {
        search_input.val('');
    });

});