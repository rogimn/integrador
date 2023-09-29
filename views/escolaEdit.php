<?php

// limpa o cache

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// chama os arquivos necessários

require_once '../config/app.php';
require_once '../models/Database.php';
require_once '../models/Escola.php';

// controle de sessão

if (is_session_started() === TRUE) {
    if (empty($_SESSION['key'])) {
        header('location: ./');
    }
}

// abre a conexão com o banco

$database = new Database();
$db = $database->getConnection();

// inicializa uma instância da classe

$escola = new Escola($db);

// Variáveis de controle

$escola->idescola = $_GET['' . $cfg['id']['escola'] . ''];

// executa a consulta e retorna

if ($sql = $escola->readSingle()) {
    if ($sql->rowCount() > 0) {
        $row = $sql->fetch(PDO::FETCH_OBJ);
?>

        <form class="form-edit-escola">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span>Editar os dados da Escola</span>
                </h4>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="rand" id="rand_edit" value="<?= md5(mt_rand()); ?>">
                <input type="hidden" name="idescola" id="idescola_edit" value="<?= $row->idescola; ?>">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="nome">Nome</label>
                            </div>
                            <div class="col-9">
                                <input type="text" name="nome" id="nome_edit" value="<?= $row->nome; ?>" minlength="2" maxlength="200" class="form-control" title="Informe o nome do escola" placeholder="Nome" required>
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="cep">CEP</label>
                            </div>
                            <div class="col-4">
                                <input type="text" name="cep" id="cep_edit" value="<?= $row->cep; ?>" minlength="9" maxlength="9" class="form-control" title="Informe o CEP" placeholder="CEP" required>
                            </div>
                            <div class="col-5">
                                <cite class="msg-cep-edit"></cite>
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="logradouro">Logradouro</label>
                            </div>
                            <div class="col-9">
                                <input type="text" name="logradouro" id="logradouro_edit" value="<?= $row->logradouro; ?>" minlength="2" maxlength="200" class="form-control" title="Informe o Logradouro" placeholder="Logradouro" readonly>
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="numero">N&uacute;mero</label>
                            </div>
                            <div class="col-9">
                                <input type="text" name="numero" id="numero_edit" value="<?= $row->numero; ?>" minlength="2" maxlength="10" class="form-control col-6" title="Informe o N&uacute;mero" placeholder="N&uacute;mero" required>
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="bairro">Bairro</label>
                            </div>
                            <div class="col-9">
                                <input type="text" name="bairro" id="bairro_edit" value="<?= $row->bairro; ?>" minlength="2" maxlength="100" class="form-control" title="Informe o Bairro" placeholder="Bairro" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="cidade">Cidade</label>
                            </div>
                            <div class="col-9">
                                <input type="text" name="cidade" id="cidade_edit" value="<?= $row->cidade; ?>" minlength="2" maxlength="100" class="form-control" title="Informe a Cidade" placeholder="Cidade" readonly>
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="uf">UF</label>
                            </div>
                            <div class="col-9">
                                <!--<select name="uf" id="uf" class="selectpicker show-tick form-control" title="Selecione a Unidade Federativa" placeholder="UF" data-width="" data-size="7">-->
                                <select name="uf" id="uf_edit" class="form-control col-6" title="Selecione a Unidade Federativa" placeholder="UF" readonly>
                                
                                <?php
                                    if ($row->uf == 'AC') {echo'<option value="AC" selected="selected">AC</option>';} else {echo'<option value="AC">AC</option>'; $a = 1;}
                                    if ($row->uf == 'AL') {echo'<option value="AL" selected="selected">AL</option>';} else {echo'<option value="AL">AL</option>'; $a++;}
                                    if ($row->uf == 'AM') {echo'<option value="AM" selected="selected">AM</option>';} else {echo'<option value="AM">AM</option>'; $a++;}
                                    if ($row->uf == 'AP') {echo'<option value="AP" selected="selected">AP</option>';} else {echo'<option value="AP">AP</option>'; $a++;}
                                    if ($row->uf == 'BA') {echo'<option value="BA" selected="selected">BA</option>';} else {echo'<option value="BA">BA</option>'; $a++;}
                                    if ($row->uf == 'CE') {echo'<option value="CE" selected="selected">CE</option>';} else {echo'<option value="CE">CE</option>'; $a++;}
                                    if ($row->uf == 'DF') {echo'<option value="DF" selected="selected">DF</option>';} else {echo'<option value="DF">DF</option>'; $a++;}
                                    if ($row->uf == 'ES') {echo'<option value="ES" selected="selected">ES</option>';} else {echo'<option value="ES">ES</option>'; $a++;}
                                    if ($row->uf == 'GO') {echo'<option value="GO" selected="selected">GO</option>';} else {echo'<option value="GO">GO</option>'; $a++;}
                                    if ($row->uf == 'MA') {echo'<option value="MA" selected="selected">MA</option>';} else {echo'<option value="MA">MA</option>'; $a++;}
                                    if ($row->uf == 'MG') {echo'<option value="MG" selected="selected">MG</option>';} else {echo'<option value="MG">MG</option>'; $a++;}
                                    if ($row->uf == 'MS') {echo'<option value="MS" selected="selected">MS</option>';} else {echo'<option value="MS">MS</option>'; $a++;}
                                    if ($row->uf == 'MT') {echo'<option value="MT" selected="selected">MT</option>';} else {echo'<option value="MT">MT</option>'; $a++;}
                                    if ($row->uf == 'PA') {echo'<option value="PA" selected="selected">PA</option>';} else {echo'<option value="PA">PA</option>'; $a++;}
                                    if ($row->uf == 'PB') {echo'<option value="PB" selected="selected">PB</option>';} else {echo'<option value="PB">PB</option>'; $a++;}
                                    if ($row->uf == 'PE') {echo'<option value="PE" selected="selected">PE</option>';} else {echo'<option value="PE">PE</option>'; $a++;}
                                    if ($row->uf == 'PI') {echo'<option value="PI" selected="selected">PI</option>';} else {echo'<option value="PI">PI</option>'; $a++;}
                                    if ($row->uf == 'PR') {echo'<option value="PR" selected="selected">PR</option>';} else {echo'<option value="PR">PR</option>'; $a++;}
                                    if ($row->uf == 'RJ') {echo'<option value="RJ" selected="selected">RJ</option>';} else {echo'<option value="RJ">RJ</option>'; $a++;}
                                    if ($row->uf == 'RN') {echo'<option value="RN" selected="selected">RN</option>';} else {echo'<option value="RN">RN</option>'; $a++;}
                                    if ($row->uf == 'RO') {echo'<option value="RO" selected="selected">RO</option>';} else {echo'<option value="RO">RO</option>'; $a++;}
                                    if ($row->uf == 'RR') {echo'<option value="RR" selected="selected">RR</option>';} else {echo'<option value="RR">RR</option>'; $a++;}
                                    if ($row->uf == 'RS') {echo'<option value="RS" selected="selected">RS</option>';} else {echo'<option value="RS">RS</option>'; $a++;}
                                    if ($row->uf == 'SC') {echo'<option value="SC" selected="selected">SC</option>';} else {echo'<option value="SC">SC</option>'; $a++;}
                                    if ($row->uf == 'SE') {echo'<option value="SE" selected="selected">SE</option>';} else {echo'<option value="SE">SE</option>'; $a++;}
                                    if ($row->uf == 'SP') {echo'<option value="SP" selected="selected">SP</option>';} else {echo'<option value="SP">SP</option>'; $a++;}
                                    if ($row->uf == 'TO') {echo'<option value="TO" selected="selected">TO</option>';} else {echo'<option value="TO">TO</option>'; $a++;}

                                    if ($a == 27) {
                                        echo'
                                        <option value="AC">AC</option>
                                        <option value="AL">AL</option>
                                        <option value="AM">AM</option>
                                        <option value="AP">AP</option>
                                        <option value="BA">BA</option>
                                        <option value="CE">CE</option>
                                        <option value="DF">DF</option>
                                        <option value="ES">ES</option>
                                        <option value="GO">GO</option>
                                        <option value="MA">MA</option>
                                        <option value="MG">MG</option>
                                        <option value="MS">MS</option>
                                        <option value="MT">MT</option>
                                        <option value="PA">PA</option>
                                        <option value="PB">PB</option>
                                        <option value="PE">PE</option>
                                        <option value="PI">PI</option>
                                        <option value="PR">PR</option>
                                        <option value="RJ">RJ</option>
                                        <option value="RN">RN</option>
                                        <option value="RO">RO</option>
                                        <option value="RR">RR</option>
                                        <option value="RS">RS</option>
                                        <option value="SC">SC</option>
                                        <option value="SE">SE</option>
                                        <option value="SP">SP</option>
                                        <option value="TO">TO</option>';
                                    }  
                                ?>

                                </select>
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text" for="celular">Celular</label>
                            </div>
                            <div class="col-9">
                                <input type="text" name="celular" id="celular_edit" value="<?= $row->celular; ?>" minlength="11" maxlength="15" class="form-control col-6" title="Informe um contato por Celular" placeholder="Celular">
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text" for="telefone">Telefone</label>
                            </div>
                            <div class="col-9">
                                <input type="text" name="telefone" id="telefone_edit" value="<?= $row->telefone; ?>" minlength="10" maxlength="15" class="form-control col-6" title="Informe um contato por Telefone" placeholder="Telefone">
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text text-danger" for="senha">E-mail</label>
                            </div>
                            <div class="col-9">
                                <input type="email" name="email" id="email_edit" value="<?= $row->email; ?>" minlength="5" maxlength="100" class="form-control" title="Informe um e-mail v&aacute;lido" placeholder="Email" required>
                            </div>
                        </div>

                        <div class="row form-group g-3 align-items-center">
                            <div class="col-3">
                                <label class="text" for="observacao">Observa&ccedil;&atilde;o</label>
                            </div>
                            <div class="col-9">
                                <textarea name="observacao" id="observacao_edit" class="form-control" title="Se tiver alguma observa&ccedil;&atilde;o, esse &eacute o momento." placeholder="Observa&ccedil;&atilde;o"><?= $row->observacao; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex">
                <div class="mr-auto">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>

                <div class="ml-auto">
                    <button type="reset" class="btn btn-secondary">Restaurar dados iniciais</button>
                    <button type="submit" class="btn btn-primary btn-edit-escola">Salvar</button>
                </div>
            </div>
        </form>

        <script>
            $(document).ready(function () {
                const fade = 150,
                    delay = 100,
                    Toast = Swal.mixin(
                        { toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 }
                    );

                // MASK
        
                $('#cep_edit').inputmask('99999-999');
                $('#celular_edit').inputmask('(99)99999-9999');
                $('#telefone_edit').inputmask('(99)9999-9999');

                // CHECK CEP

                function checkCEP() {
                    $.post('loadCEP', {
                        cep: $.trim($('#cep_edit').val())
                    }, data => {
                        let parsed = $.parseJSON(data);
                        
                        if (parsed.resultado === '1') {
                            $('#logradouro_edit').val(parsed.tipo_logradouro + ' ' + parsed.logradouro);
                            $('#bairro_edit').val($.trim(parsed.bairro));
                            $('#cidade_edit').val($.trim(parsed.cidade));
                            $('#uf_edit').val(parsed.uf);
                            $('#cep_edit').css('background', 'transparent');
                            $('.msg-cep-edit').addClass('text-success').removeClass('text-danger').css('display', 'block').html('CEP V&aacute;lido!');
                        } else {
                            $('#logradouro_edit').val('');
                            $('#bairro_edit').val('');
                            $('#cidade_edit').val('');
                            $('#uf_edit').val('');
                            $('#cep_edit').focus().css('background', 'transparent');
                            $('.msg-cep-edit').addClass('text-danger').removeClass('text-success').css('display', 'block').html('CEP Inv&aacute;lido!');
                        }
                    });
                }

                $('#cep_edit').keyup(function() {
                    if ($('#cep_edit').val().length == 9) {
                        if (!$('#cep_edit').val().match(/_/g)) {
                            checkCEP();
                            $('#cep_edit').css('background', 'transparent url("dist/img/rings-black.svg") right center no-repeat');
                        }
                    } else {
                        $('#cep_edit').val('');
                        $('.msg-cep-edit').css('display', 'none');
                    }
                });

                // EDITAR ESCOLA

                $('.form-edit-escola').submit(function (e) {
                    e.preventDefault();

                    $.post('escolaUpdate', $(this).serialize(), function (data) {
                        $('.btn-edit-escola').html('<img src="dist/img/rings.svg" class="loader-svg">').fadeTo(fade, 1);

                        switch (data) {
                            case 'true':
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Escola editada.'
                                }).then((result) => {
                                    window.setTimeout("location.href='escolas'", delay);
                                });
                                break;

                            default:
                                Toast.fire({
                                    icon: 'error',
                                    title: data
                                });
                                break;
                        }

                        $('.btn-edit-escola').html('Salvar').fadeTo(fade, 1);
                    });

                    return false;
                });
            });
        </script>

<?php
    } else {
        echo
        '<blockquote class="quote-danger">
            <h5>' . $cfg['error']['title'] . '</h5>
            <p>' . $cfg['error']['msg'] . '</p>
        </blockquote>';
    }
} else {
    die(var_dump($db->errorInfo()));
}

unset($cfg, $database, $db, $escola, $sql, $row, $a);