
    <hr>
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2015</p>
                </div>
            </div>
        </footer>

    </div>

    <script src="/content/js/jquery.js"></script>
    <script src="/content/js/bootstrap.min.js"></script>
    <script src="/content/js/star-rating.js"></script>
    
    <script>
        $(".messages").slideDown("fast");
        setTimeout( "$('.messages').slideUp('fast');", 2000);
        $(".messages").on("click", function(){
            $(this).slideUp("fast");
        });
        $("audio").on("play", function(){
            var _this = $(this);
            $("audio").each(function(i,el){
                if(!$(el).is(_this))
                    $(el).get(0).pause();
            });
        });
        $('.rating').on('rating.change', function(event, value, caption) {
            this.form.submit();
        });
    </script>

</body>

</html>