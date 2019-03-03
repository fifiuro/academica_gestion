<li class="treeview">
    <a href="#">
        <i class="fa fa-gears"></i>
        <span>CONFIGURACIONES</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="{{ url('findCargo') }}">
                <i class="fa fa-circle-o"></i> Cargos</a>
        </li>
        <li>
            <a href="{{ url('findDepartamento') }}">
                <i class="fa fa-circle-o"></i> Departamento</a>
        </li>
        <li>
            <a href="{{ url('findFeriado') }}">
                <i class="fa fa-circle-o"></i> Feriados</a>
        </li>
        <li>
            <a href="{{ url('findCategoria') }}">
                <i class="fa fa-circle-o"></i> Tecnologías</a>
        </li>
        <li>
            <a href="{{ url('findAula') }}">
                <i class="fa fa-circle-o"></i> Aulas</a>
        </li>
        <li>
            <a href="{{ url('findPago') }}">
                <i class="fa fa-circle-o"></i> Tipos de Pago</a>
        </li>
        <li>
            <a href="{{ url('findDocumento') }}">
                <i class="fa fa-circle-o"></i> Documentos Respaldo</a>
        </li>
    </ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-institution"></i>
        <span>COGNOS</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="{{ url('findPersonal') }}">
                <i class="fa fa-circle-o"></i> Personal Cognos</a>
        </li>
        <li>
            <a href="{{ url('findCurso') }}">
                <i class="fa fa-circle-o"></i> Cursos</a>
        </li>
        <li>
            <a href="{{ url('findInstructor') }}">
                <i class="fa fa-circle-o"></i> Instructores</a>
        </li>
        <li>
            <a href="{{ url('findEmpresa') }}">
                <i class="fa fa-circle-o"></i> Empresas</a>
        </li>
    </ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-group"></i>
        <span>CLIENTES</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="#">
                <i class="fa fa-circle-o"></i> Alumno</a>
        </li>
        <li>
            <a href="{{ url('findInteres') }}">
                <i class="fa fa-circle-o"></i> Interesado</a>
        </li>
        <li>
            <a href="#">
                <i class="fa fa-circle-o"></i> Empresas</a>
        </li>
    </ul>
</li>
<li>
    <a href="{{ url('findCronograma') }}">
        <i class="fa fa-calendar"></i>
        <span>CRONOGRAMA</span>
    </a>
</li>
<li>
    <a href="{{ url('createInicio') }}">
        <i class="fa fa-check"></i>
        <span>INICIO</span>
    </a>
</li>