//Load posts list
$(document).ready(function() {
    /*$.ajax({
        url: "/blog/posts/load/",
        type: "POST",
        dataType: "json",
        data: {
        },
        error: function(data) {
            alert('AJAX response for "' + this.url + '" error:\n' + data.responseText);
        },
        success : function(data) {
            console.log('AJAX response for "' + this.url + '" success.');
            
            if (data.result == 'success') {
                posts = data.posts;
            }
            
            //Sort object by datetime of creation
            posts.sort(function(b,a){
                return new Date(b.created_at) - new Date(a.created_at);
            });
            
            //Add post content
            $.each(posts, function(key, post) {
              addPostMedia(post);
            });
        }
    });*/
});

$('#addPostForm').validator({
    disable: true,
    focus: false,
    custom: {
        noempty: function($el) {
            //Get value of form element
            value = $el.val();

            //Make check only, if no processed by 'required' attribute
            //to prevent second message to be appeared
            if (value !== '') {
                if ($.trim(value) === '') {
                    return 'Поле не должно быть пустым.';
                }
            }
        }
    }
}).on('submit', function(event) {
    //Do nothing if some form checks is invalid
    if (event.isDefaultPrevented()) {
       return;
    }

    //Define helper variables
    let title = $("#inputTitle").val();
    let text = $("#inputText").val();

    //По условиям задачи испоьлзуем чистый PHP
    $.ajax({
        url: "/blog/post/add",
        type: "POST",
        dataType: "json",
        data: {
            title: title,
            text: text
        },
        error: function(data) {
            alert('AJAX response for "' + this.url + '" error:\n' + data.responseText);
        },
        success : function(data) {
            if (data.result == 'success') {
                addPostMedia({title, text});
                $('#addPostModal').modal('hide');
                $("#inputTitle").val('');
                $("#inputText").val('');
            }
        }
    });
});

function addPostMedia(post)
{
    //Create inside divs
    let $div = $("<div class='media'></div>");
    let $divLeft = $("<div class='media-left'></div>");
    let $title = $("<h4>" + post.title + "</h4>");
    let $divBody = $("<div class='media-body'></div>");
    let $img = $(
        "<a href=''><img src='#' alt='' class='media-object post-image'></a>");
    //Structure divs
    $divLeft.prepend($img);
    $divBody.prepend($title);
    $divBody.append(post.text);
    $div.prepend($divLeft);
    $div.append($divBody);
    //Attach ready media to container
    $('#postsList').prepend($div);
}
