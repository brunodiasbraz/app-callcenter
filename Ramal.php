<?php
include 'comum.php';
?>

<body>


    <div class="container col-sm-12 col-md-8">
        <form action="inserirRamal.php" method="POST">
            <div class="form-group col-sm-12 col-md-12">
                <label class="mt-5" for="">Conta Ramal Sip</label>
                <input name="rama_sip" type="text" class="form-control" id="" placeholder="" autofocus required>
                <small class="form-text text-muted">Digite aqui a conta SIP.</small>

                <label for="">Senha :</label>
                <input name="senha_ramal_sip" type="password" class="form-control" id="" placeholder="" required>
                <small class="form-text text-muted">Digite aqui senha.</small>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">Permição de chamadas</label>
                    <select name="contexto_ramal_sip" class="form-control" id="exampleFormControlSelect1">
                        <option value="phones">Chamadas internas(phones)</option>
                        <option value="phones-local">Chamadas Locais</option>
                        <option value="phones-local-celular">Chamadas Locais e Celular</option>
                        <option value="phones-ddd-fixo">Chamadas DDD Fixo</option>
                        <option value="phones-ddd-fixo-celular">Chamadas DDD fixo e celular</option>
                        <option value="phones-ddi">Chamadas DDI</option>
                    </select>
                </div>


                <label for="">Tipo de host Dynamic </label>
                <input name="dinamic_static_ramal_sip" readonly="readonly" value="dynamic" type="text"
                    class="form-control" id="" placeholder="">
                <small class="form-text text-muted">Digite o ip ou dinamico .</small>
                <button type="submit" class="mt-2 btn btn-primary col-sm-12 col-md-12">Submit</button>
            </div>

        </form>
    </div>






    <!-- 
<script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/popper.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script> -->


</body>
<!-- os scrips vem do comum.php -->

</html>