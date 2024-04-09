<?php
include 'comum.php';

?>

<body>


    <div class="container col-sm-12 col-md-12">
        <form action="consultaRamal_2.php" method="POST">
            <div class="form-group col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-sm-3 col-md-3">
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <label class="mt-5" for="">Ramais Iniciados com ...</label>
                        <input name="rama_sip" type="text" class="form-control" id="" placeholder="" autofocus>
                        <small class="form-text text-muted">Digite aqui .</small>
                        <button type="submit" class="btn btn-primary col-sm-12 col-md-12">Deletar Ramal </button>
                    </div>
                    <div class="col-sm-3 col-md-3">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php

?>
</body>
<!-- os scrips vem do comum.php -->

</html>