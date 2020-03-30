<!DOCTYPE html>
<html lang="en">

<head>
    <title>Trắc nghiệm online</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>
<script>
    jQuery(document).ready(function($) {
        //id package
        var score= 0;
        var id_package = <?php echo $_GET['id']; ?> ;
        var page = -1; //ofset 0, 1
        var right_answer = 0;
        function loadQuestion() {
            page++;
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id_package,
                    page: page
                },
            })
            .done(function(res) {
                //load vào giao diện qua DOM
                let data = res;
                console.log(data);
                let question =data.question;
                let answers = data.answers;



                for (var i = 0; i < answers.length; i++) {
                    var element = answers[i];
                    if(element.is_correct==1){
                        right_answer = element.id;
                        break;
                    }
                };

                $('.question-title').html(question.title);
                $('.question-desc').html(question.content);

                $('.form-answer').empty();
                for (var i = 0; i< answers.length;i++) {
                    let elem = answers[i];
                    $('.form-answer').append(`<div>
                        <input type="radio" name="answers" 
                        value="${elem.id}" />
                        &nbsp;${elem.content}
                        </div>`); //string literal -> featured mới trong javascript es 6
                };
            })
            .fail(function() {
                //thông báo lỗi 
                alert("Không thể tải câu hỏi");
            })
        }

        loadQuestion();
        $('.btn-next').bind('click',function(){
            var answer = -1;
            $('.form-answer input[type="radio"]').each(function(index, el) {
                if($(this).is(':checked')){
                    answer = $(this).val();
                }
            });
            if(answer==-1){
                alert("Vui lòng chọn câu trả lời");
                return;
            }

            if(answer == right_answer){
                score++;
                $('.score').html(score);
                alert("Bạn trả lời đúng");
            }else{
                alert("Bạn trả lời sai");
            }

            loadQuestion();
        })
    });


</script>
</head>


<body>
    <div class="container">
        <div class="row">
            <div>
                <div class="score">0</div>
                <h5 class="question-title">
                    Câu hỏi 1
                </h5>

                <p class="question-desc">
                    Lorem Ipsum dolor sit amet, consectetur adipiscing elit
                </p>

                <form class="form-answer">

                </form>

            </div>
        </div>

        <div class="btn btn-primary btn-next">Câu hỏi tiếp</div>
    </div>
</body>

</html>