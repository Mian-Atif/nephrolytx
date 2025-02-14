<!--Action Button-->
@if( Active::checkUriPattern( 'admin/practices' ) )
    <div class="btn-group">
        <button type="button" class="btn btn-warning btn-flat dropdown-toggle" data-toggle="dropdown">Export
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li id="copyButton" style="font-size: 13px;padding: 0 5px;"><a href="#" style="color: #fff;"><i class="fa fa-clone"></i> Copy</a></li>
            <li id="csvButton" style="font-size: 13px;padding: 0 5px;"><a href="#" style="color: #fff;"><i class="fa fa-file-text-o"></i> CSV</a></li>
            <li id="excelButton" style="font-size: 13px;padding: 0 5px;"><a href="#" style="color: #fff;"><i class="fa fa-file-excel-o"></i> Excel</a></li>
            <li id="pdfButton" style="font-size: 13px;padding: 0 5px;"><a href="#" style="color: #fff;"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
            <li id="printButton" style="font-size: 13px;padding: 0 5px;"><a href="#" style="color: #fff;"><i class="fa fa-print"></i> Print</a></li>
        </ul>
    </div>
@endif
<!--Action Button-->
<div class="btn-group">
    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">Action
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li style="font-size: 13px;padding: 0 5px;">
            <a href="{{ route( 'admin.practices.index' ) }}" style="color: #fff;">
                <i class="fa fa-list-ul"></i> {{ trans( 'menus.backend.practices.all' ) }}
            </a>
        </li>
        @permission( 'create-practice' )
            <li style="font-size: 13px;padding: 0 5px;">
                <a href="{{ route( 'admin.practices.create' ) }}" style="color: #fff;">
                    <i class="fa fa-plus"></i> {{ trans( 'menus.backend.practices.create' ) }}
                </a>
            </li>
        @endauth
    </ul>
</div>
<div class="clearfix"></div>
