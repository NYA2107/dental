@extends('../../dashboard')

@section('title')
    Antrian
@endsection

@section('content')
@if(\Session::has('msg'))
    <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>Success - </strong> {!! \Session::get('msg') !!}
    </div>
@endif
@if($errors->first('error'))
    <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <strong>Error - </strong> {!! $errors->first('error') !!}
    </div>
@endif
<div id="app"> </div>
<script src="{{url('react/babel.min.js')}}"></script>
<script src="{{url('react/lodash.min.js')}}"></script>
<script crossorigin src="{{url('react/react.production.min.js')}}"></script>
<script crossorigin src="{{url('react/react-dom.production.min.js')}}"></script>
<script src="{{url('react/axios.min.js')}}"></script>
<script type="text/babel">

    class App extends React.Component{

        state={
            antrian:[]
        }

        audio = new Audio("{{ URL::to('/') }}/bell-ringing-05.mp3")

        async componentDidMount(){
            this.fetchInterval = setInterval(this.fetch, 2000)
            this.fetch()
        }
        componentWillUnmount() {
            clearInterval(this.fetchInterval);
        }

        fetch = async () =>{
            let currentData = JSON.parse(JSON.stringify(this.state.antrian))
            let {data} = await axios.post("{{route('antrian-get-json')}}")
            if(!_.isEqual(currentData, data)){
                this.audio.play()
                this.setState({antrian:data})
            }
            
        }

        setAntrian = async (data) =>{
            let {status_code} = await axios.post("{{route('antrian-set-json')}}", data)
            return status_code
        }

        handleChange=(e)=>{
            this.setState({msg:e.target.value})
        }

        handleClick= async (e)=>{
            let action = e.target.name
            let value = e.target.value
            let temp = JSON.parse(JSON.stringify(this.state.antrian))
            if(action === 'up'){
                let index = _.findIndex(temp, v =>{
                    return v.id == value
                })
                let wadah = JSON.parse(JSON.stringify(temp[index - 1]))
                temp[index -1] = temp[index]
                temp[index] = wadah
                await this.setAntrian({data:temp})
                await this.fetch()
            }else if(action === 'down'){
                let index = _.findIndex(temp, v =>{
                    return v.id == value
                })
                let wadah = JSON.parse(JSON.stringify(temp[index + 1]))
                temp[index + 1] = temp[index]
                temp[index] = wadah
                await this.setAntrian({data:temp})
                await this.fetch()
            }else if(action == 'delete'){
                _.remove(temp, v =>{
                    return v.id == value
                })
                await this.setAntrian({data:temp})
                await this.fetch()
            }else if(action == 'next'){
                temp.shift()
                await this.setAntrian({data:temp})
                await this.fetch()
            }
        }

        grid = {display:'grid', gridTemplateColumns:'1fr 5em', gridGap:'1em'}
        gridButton = {display:'grid', gridTemplateRows:'2.5em 2.5em', gridGap:'1em'}
        gridDetail = {display:'grid', gridTemplateColumns:'10em 10em', gridGap:'1em'}
        render(){
            const {antrian} = this.state
            return(
                <div>
                    <div className="card">
                        <div className="card-body">
                            <h4 className="card-title">Antrian Pasien</h4>
                            <h6 className="card-subtitle">Cari pasien berdasarkan nama, nomer rekam medis atau usia pasien (form boleh dikosingi atau pilih beberapa)</h6>
                            <button className="btn btn-success" onClick={this.handleClick} name="next">Pasien Selanjutnya</button>    
                        </div>
                    </div>
                    {antrian.map((v,i) =>{
                        if(i === 0){
                            return (
                                <div className="card">
                                    <div className="card-body bg-dark text-white" style={this.grid}>
                                        <div>
                                            <p>Nama : {v.nama}</p>
                                            <p>No Rekam Medis : {v.no_rekam_medis} </p>
                                        </div>  
                                        <div style={this.gridButton}>
                                            <button onClick={this.handleClick} name="down" value={v.id} className="btn btn-info">Down</button>
                                        </div>
                                        <div style={this.gridDetail}>
                                            <button onClick={this.handleClick} name="delete" value={v.id} className="btn btn-danger">Delete</button>
                                            <a className="btn btn-primary" href={`/dental/public/pasien/${v.id}`}>Detail Pasien</a>
                                        </div>
                                    </div>                                    
                                </div>
                            )
                        }else if(i < antrian.length-1){
                            return (
                                <div className="card">
                                    <div className="card-body" style={this.grid}>
                                        <div>
                                            <p>Nama : {v.nama}</p>
                                            <p>No Rekam Medis : {v.no_rekam_medis} </p>
                                        </div>  
                                        <div style={this.gridButton}>
                                            <button onClick={this.handleClick} name="up" value={v.id} className="btn btn-dark">Up</button>
                                            <button onClick={this.handleClick} name="down" value={v.id} className="btn btn-dark">Down</button>
                                        </div>
                                        <div style={this.gridDetail}>
                                            <button onClick={this.handleClick} name="delete" value={v.id} className="btn btn-danger">Delete</button>
                                            <a className="btn btn-primary" href={`/dental/public/pasien/${v.id}`}>Detail Pasien</a>
                                        </div>
                                    </div>
                                </div>
                            )
                        }else{
                            return (
                                <div className="card">
                                    <div className="card-body" style={this.grid}>
                                        <div>
                                            <p>Nama : {v.nama}</p>
                                            <p>No Rekam Medis : {v.no_rekam_medis} </p>
                                        </div>  
                                        <div style={this.gridButton}>
                                            <button onClick={this.handleClick} name="up" value={v.id} className="btn btn-dark">Up</button>
                                        </div>
                                        <div style={this.gridDetail}>
                                            <button onClick={this.handleClick} name="delete" value={v.id} className="btn btn-danger">Delete</button>
                                            <a className="btn btn-primary" href={`/dental/public/pasien/${v.id}`}>Detail Pasien</a>
                                        </div>
                                    </div>
                                </div>
                            )
                        }
                        
                    })}  
                </div>
            )
        }
    }
    ReactDOM.render(<App/>, document.getElementById('app'))
</script>
@endsection