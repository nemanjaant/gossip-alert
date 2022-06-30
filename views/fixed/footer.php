<footer class="container">
        <div class="row text-center p-3">
            
                    <form action="#" id="userMessages">
                        <legend>javite nam trač</legend>
                        <fieldset>
                            <div class="form-group col-12">
                                <label for="name">Ime</label>
                                <input type="text" name="name" id="name">
                                <span class="error"></span>
                            </div>
                            <div class="form-group col-12">
                                <label for="surname">Prezime</label>
                                <input type="text" name="surname" id="surname">
                                <span class="error"></span>
                            </div>
                            <div class="form-group col-12">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" id="email">
                                <span class="error"></span>
                            </div>
                            <div class="form-group col-12">
                                <label for="infoagreement">Pristajem na uslove obrade informacija</label>
                                <input type="checkbox" name="infoagreement" id="infoagreement">
                                <span class="error"></span>
                            </div>
                            <div class="form-group col-12">
                                <label for="message"class="col-12">Olakšajte dušu:</label>
                                <textarea name="message" id="message" cols="40" rows="5"></textarea>
                                <span class="error"></span>
                            </div>
                            <div class="form-group col-12">
                                <input type="button" id="sendbtn" name="sendbtn" value="Pošalji" class="btn btn-warning">
                            </div>
                            <div id="response"></div>

                        </fieldset>
                    </form>
        </div>
        <div class="container text-center mt-5" id="meta">
            <span><a href="index.php?page=author">AUTOR</a> | <a href="dokumentacija.pdf">DOKUMENTACIJA</a></span>
        </div>
    </footer>
        
<script type="text/javascript" src="assets/js/functions.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>
<script type="text/javascript">



</script>


</body>
</html>