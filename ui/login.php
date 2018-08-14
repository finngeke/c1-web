<h2 class="login-box-msg"><B>C1</B> Automática Web</h2>
<form action="{{@BASE}}/login" method="POST" class="login">
    <div class="form-group has-feedback">
        <input type="text" name="usuario" class="form-control" placeholder="Usuario de Windows" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="password" name="clave" class="form-control" placeholder="Contraseña" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
        <!--<div class="col-md-6">
            <div class="checkbox icheck">
                <label>
                    <input type="checkbox"> Mantener la sesión 
                </label>
            </div>
        </div>-->
        <div class="col-md-6">
            <div class="form-group">
                  <select id="select_control_conexion" name="select_control_conexion" class="form-control">
                    <option value="PROD" selected>PROD</option>
                    <!--<option value="1">CER</option>-->
                    <option value="QA">QA</option>
                  </select>
                </div>
        </div>
        
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar sesión</button>
        </div>
    </div>
</form>
