@extends('layout.master')
<script type="text/javascript">var centreGot = false;</script>{!!$map['js']!!}
@section('css_vendor')

@stop

@section('js_vendor')

@stop

@section('content')

        <section id="content">

            <div class="container">


    
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="f-22 f-300 text-center">Mapas</div>
                        </div>
                    </div>    
                </div>



                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h2>Mapa</h2>
                                <ul class="actions">
                                    <li class="dropdown action-show">
                                        <a href="#" data-toggle="dropdown">
                                            <i class="zmdi zmdi-more-vert"></i>
                                        </a>
                        
                                        <div class="dropdown-menu pull-right">
                                            <p class="p-20">
                                                You can put anything here
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="card-body card-padding">
                                <input type="text" name="" class="form-control caja" id="coord">
                                <div class="clearfix"><hr></div>
                                {!!$map['html']!!}
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12">
                        

                        <div class="card">
                            <div class="card-header">
                                <h2>Simple File Input <small>The file input plugin allows you to create a visually appealing file or image input widgets</small></h2>
                            </div>
                            
                            <div class="card-body card-padding">
                                
                                <br/>
                                <br/>
                                
                                <p class="f-500 c-black m-b-20">Image Preview</p>
                                
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                                    <div>
                                        <span class="btn btn-info btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="...">
                                        </span>
                                        <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                                
                                <br/>
                                <br/>
                                <p><em>Image preview only works in IE10+, FF3.6+, Safari6.0+, Chrome6.0+ and Opera11.1+. In older browsers the filename is shown instead.</em></p>
                            </div>
                        </div>


                    </div>


                
            </div>

        </section>


@stop


@section('js') 

<script>

$(document).ready(function() {
    

})

function addFieldText(newLat, newLng){
    $('#coord').val(newLat+', '+newLng);
}



</script>


@stop