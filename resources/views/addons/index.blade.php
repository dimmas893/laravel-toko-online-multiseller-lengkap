@extends('layouts.app')

@section('content')

    <div class="bord-btm mar-btm">
        <div class="row ">
            <div class="col-sm-6">
                <ul class="nav nav-tabs addon-tab ">
                    <li class="active"><a data-toggle="tab" href="#installed">Installed Addon</a></li>
                    <li><a data-toggle="tab" href="#available">Available Addon</a></li>
                </ul>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('addons.create')}}" class="btn btn-rounded btn-info">{{__('Install New Addon')}}</a>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="installed">
            <div class="row">
                @forelse(\App\Addon::all() as $key => $addon)
                    <div class="col-lg-4 col-md-6">
                        <div class="panel addon-panel">
                            <div class="panel-header">
                                <img class="img-responsive" src="{{ asset($addon->image) }}" alt="Image">
                                <div class="overlay" data-toggle="modal" data-target="#myModal-{{ $key }}">
                                    <i class="fa fa-info"></i>
                                </div>
                                <div class="modal fade" tabindex="-1" role="dialog" id="myModal-{{ $key }}">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bord-btm">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">{{ ucfirst($addon->name) }}</h4>
                                            </div>
                                            <div class="modal-body blog">
                                                <div class="panel clearfix pad-no mar-no">
                                                    <div class="blog-header">
                                                        <img class="img-responsive" src="{{ asset($addon->image) }}" alt="Image">
                                                    </div>
                                                    <div class="blog-content text-center">
                                                        <div class="pad-lft">
                                                            <div class="blog-title">
                                                                <h3>{{ ucfirst($addon->name) }}</h3>
                                                            </div>
                                                            <div class="blog-body">
                                                                <p><small>Version: </small>{{ $addon->version }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body pad-no">
                                <label class="activated-switch">
                                    <input type="checkbox" onchange="updateStatus(this, {{ $addon->id }})" <?php if($addon->activated) echo "checked";?>>
                                    <span class="bg-success active">Activated</span>
                                    <span class="bg-gray-dark deactive">Deactivated</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-4 col-md-6 col-lg-offset-4">
                        <div class="panel addon-panel">
                            <div class="panel-header">
                                <img class="img-responsive" src="{{ asset('img/nothing-found.jpg') }}" alt="Image">
                            </div>
                            <div class="panel-body text-center">
                                <div class="media-block mar-btm">
                                    <h2 class="h3">No Addon Installed</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="tab-pane fade" id="available">
            <div class="row" id="available-addons-content">

            </div>
        </div>
    </div>




@endsection

@section('script')
    <script type="text/javascript">
        function updateStatus(el, id){
            if($(el).is(':checked')){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('addons.activation') }}', {_token:'{{ csrf_token() }}', id:id, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Status updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        $(document).ready(function(){
            $.post('https://activeitzone.com/addons/public/addons', {item: 'ecommerce'}, function(data){
                //console.log(data);
                html = '';
                data.forEach((item, i) => {
                    if(item.link != null){
                        html += `<div class="col-lg-4 col-md-6 ">
                                    <div class="panel addon-panel">
                                        <div class="panel-header">
                                            <a href="${item.link}" target="_blank"><img class="img-responsive" src="${item.image}" alt="Image"></a>
                                        </div>
                                        <div class="panel-body">
                                            <div class="media-block mar-btm"><a class="h4 mar-top d-flex" href="${item.link}" target="_blank">${item.name}</a>
                                                <div class="rating rating-lg mar-btm"><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i></div>
                                                <p class="mar-no text-truncate-3">${item.short_description}</p>
                                            </div>
                                            <div class="blog-footer pad-top">
                                                <div class="media-left text-success text-2x">$${item.price}</div>
                                                <div class="media-body text-right"><a href="${item.link}" target="_blank" class="btn btn-outline btn-default">Preview</a><a href="${item.purchase}" target="_blank" class="btn btn-outline btn-primary">Purchase</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                    }
                    else {
                        html += `<div class="col-lg-4 col-md-6 ">
                                    <div class="panel addon-panel">
                                        <div class="panel-header">
                                            <a><img class="img-responsive" src="${item.image}" alt="Image"></a>
                                        </div>
                                        <div class="panel-body">
                                            <div class="media-block mar-btm"><a class="h4 mar-top d-flex" >${item.name}</a>
                                                <div class="rating rating-lg mar-btm"><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i><i class="fa fa-star active"></i></div>
                                                <p class="mar-no text-truncate-3">${item.short_description}</p>
                                            </div>
                                            <div class="blog-footer pad-top ">
                                                <div class="media-body text-center"><div class="btn btn-outline btn-primary">Coming Soon</div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                    }

                });
                $('#available-addons-content').html(html);
            });
        })
    </script>
@endsection
