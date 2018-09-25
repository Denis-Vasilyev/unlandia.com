<template>
    <div>
        <form class="form-horizontal" @submit.prevent="submitForm">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Этажность и тип учреждения</h3>
                </div>
                <br/>
                <div class="form-group">
                    <label for="floor" class="col-sm-4 control-label text-right">Этажность учреждения:</label>
                    <div class="col-sm-6">
                        <select class="form-control" v-model="params.floorCount">
                            <option
                                v-for="(floor, index) in floors"
                                :key="index"
                                :value="floors[index]">
                                {{ floor }}
                            </option>
                        </select>
                    </div>
                </div>
                <hr/>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Тип учреждения по таблице 6.11 СП31-110-2003 для определения К1 для расчета нагрузки питающих линий:</h4>
                            </div>
                        </div><br/>
                        <div v-for="(inst, index) in institution_6_11" :key="index" class="row">
                            <div align="center" class="col-sm-1">
                                <input type="radio" name="institution_6_11" v-model.number="params.institutionType_6_11" v-bind:value="inst.type" >
                            </div>
                            <div class="col-sm-11">
                                <label>{{ inst.title }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Тип учреждения по таблице 6.5 СП31-110-2003 для определения К_с.о для расчета Рр освещения:</h4>
                            </div>
                        </div><br/>
                        <div v-for="(inst, index) in institution_6_5" :key="index" class="row">
                            <div align="center" class="col-sm-1">
                                <input type="radio" name="institution_6_5" v-model.number="params.institutionType_6_5" v-bind:value="inst.type" >
                            </div>
                            <div class="col-sm-11">
                                <label>{{ inst.title }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Данные для определения нагрузок по типу потребителя</h3>
                </div>
                <br/>
                <div class="panel panel-default" style="margin: 5px;" v-for="(item, index) in params.loadTypeData" :key="index">
                    <div class="panel-heading" style="height: 45px;">
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-danger btn-sm"  @click="delConsumer(item);$delete(params.loadTypeData,index);"><span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label>Тип потребителя:</label>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control" v-model="item.consumerTypeIndex">
                                        <option 
                                            v-for="(consum, index) in consumerTypes"
                                            v-if="consum.selected == false || item.consumerTypeIndex == index"
                                            :key="index"
                                            :value="consum.index">
                                            {{ consum.title }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="checkbox" v-model="item.fireInvolved" :disabled="item.fireInvolvedDisabledAttr" /><label>Участвует при пожаре:</label>
                                </div>
                                <div class="col-sm-3">
                                    <input type="checkbox" v-model="item.kCEditing" /><label>Указать Кс вручную:</label>
                                </div>
                            </div>
                            <br/>
                            <div class='row'>
                                <div class='col-sm-11' style="margin-left: 9px;">
                                    <div class="table-responsive"> 
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Np</td>
                                                <td>Ру, кВт</td>
                                                <td>Qу, квар</td>
                                                <td>Кс</td>
                                                <td>Pр, кВт</td>
                                                <td>Qр, квар</td>
                                                <td>cosϕ</td>
                                                <td>Tgϕ</td>
                                                <td>Sp, кВА</td>
                                                <td>Ip, A</td>
                                            </tr>
                                            <tr>
                                                <td><input type='number' v-model.number="item.Np" min=1 style="width: 55px;"></td>
                                                <td><input type='number' v-model.number="item.Py" min=0 style="width: 60px;"></td>									
                                                <td><input type='number' v-model.number="item.Qy" min=0 style="width: 63px;" disabled></td>
                                                <td><input type='number' v-model.number="item.Kc" min=0 style="width: 60px;" :disabled="!item.kCEditing"></td>
                                                <td><input type='number' v-model.number="item.Pp" min=0 style="width: 60px;" disabled></td>
                                                <td><input type='number' v-model.number="item.Qp" min=0 style="width: 63px;" disabled></td>
                                                <td><input type='number' v-model.number="item.cosf" step=0.01 min=-1.0 max=1.0 style="width: 60px;"></td>
                                                <td><input type='number' v-model.number="item.tgf" style="width: 60px;" disabled></td>
                                                <td><input type='number' v-model.number="item.Sp" min=0 style="width: 60px;" disabled></td>
                                                <td><input type='number' v-model.number="item.Ip" min=0 style="width: 60px;" disabled></td>									
                                            </tr>
                                        </table>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
                <br/>
                <div class="row">
                    <div class="col-sm-3">
                        <button type="button" @click="addConsumer" class="btn btn-danger">Добавить потребитель</button>
                    </div>
                    <div class="col-sm-3">
                        <button type="button" @click="reset" class="btn btn-default">Сброс</button>
                    </div>
                </div>
                <br/>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">СУММАРНАЯ НАГРУЗКА ПРОЕКТИРУЕМОГО ОБЪЕКТА</h3>
                </div>
                <br/>
                <div class="panel panel-body">
                    <div class="row">
                        <div class="col-md-6">	
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="control-label">Рр.осв/ Рр.сил, %:</label>
                                </div>
                                <div class="col-md-8">											
                                    <input type='number' v-model="ppOsvSil" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="control-label">Рр.осв/ Рр.хол, %:</label>
                                </div>
                                <div class="col-md-8">
                                    <input type='number' v-model="ppOsvHol" disabled>
                                </div>
                            </div>
                        </div>	
                        <div class="col-md-6">	
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">К (Рр.осв/ Рр.сил):</label>
                                </div>
                                <div class="col-md-6">											
                                    <input type='number' v-model="k" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">К1 (Рр.осв/ Рр.хол):</label>
                                </div>
                                <div class="col-md-6">											
                                    <input type='number' v-model="k1" disabled>
                                </div>
                            </div>								
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive"> 
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan=9><label class="control-label">АВАРИЙНЫЙ РЕЖИМ</label></td>
                                    </tr>
                                    <tr>
                                        <td><input type="number" v-model="pyCrash" style="width: 68px;" disabled></td>									
                                        <td><input type="number" v-model="qyCrash" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="kCrash" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="ppCrash" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="qpCrash" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="cosfCrash" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="tgfCrash" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="spCrash" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="ipCrash" style="width: 68px;" disabled></td>
                                    </tr>
                                    <tr>
                                        <td colspan=9><label class="control-label">АВАРИЙНЫЙ РЕЖИМ (ПРИ ПОЖАРЕ)</label></td>
                                    </tr>
                                    <tr>
                                        <td><input type="number" v-model="pyFire" style="width: 68px;" disabled></td>									
                                        <td><input type="number" v-model="qyFire" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="kFire" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="ppFire" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="qpFire" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="cosfFire" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="tgfFire" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="spFire" style="width: 68px;" disabled></td>
                                        <td><input type="number" v-model="ipFire" style="width: 68px;" disabled></td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">Ру, кВт</label></td>									
                                        <td><label class="control-label">Qу, квар</label></td>
                                        <td><label class="control-label">Кс</label></td>
                                        <td><label class="control-label">Pр, кВт</label></td>
                                        <td><label class="control-label">Qр, квар</label></td>
                                        <td><label class="control-label">cosϕ</label></td>
                                        <td><label class="control-label">Tgϕ</label></td>
                                        <td><label class="control-label">Sp, кВА</label></td>
                                        <td><label class="control-label">Ip, A</label></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>

function initialState() {    
    return {
        params: {
            floorCount: 5,
            institutionType_6_11: 1,
            institutionType_6_5: 1,            
            loadTypeData: []
        },       
        consumerTypes: [
            { index: 0,  title: 'Вентиляц. обор. (двиг.>30кВт)', selected: false },
            { index: 1,  title: 'Вентиляц. обор.', selected: false },
            { index: 2,  title: 'Дымоудаление', selected: false },
            { index: 3,  title: 'Кондиционер', selected: false },
            { index: 4,  title: 'Кондиционер > 30кВт', selected: false },
            { index: 5,  title: 'Лифт', selected: false },
            { index: 6,  title: 'Мед. кабинет', selected: false },
            { index: 7,  title: 'Мед. обор. тепловое', selected: false },
            { index: 8,  title: 'Мед.обор.стационарное', selected: false },
            { index: 9,  title: 'Нагревательное сантех. обор.', selected: false },
            { index: 10, title: 'Насосное обор. (двиг.>30кВт)', selected: false },
            { index: 11, title: 'Насосное обор.', selected: false },
            { index: 12, title: 'Оборудование уборочное', selected: false },
            { index: 13, title: 'ОЗДС', selected: false },
            { index: 14, title: 'Освещение аварийное', selected: false },
            { index: 15, title: 'Освещение', selected: false },
            { index: 16, title: 'Пищеблок (двиг. обор.)', selected: false },
            { index: 17, title: 'Пищеблок (теп. обор.)', selected: false },
            { index: 18, title: 'Пожарный клапан', selected: false },
            { index: 19, title: 'Пожарный насос', selected: false },
            { index: 20, title: 'Посудомоеч. маш. (гор.вода)', selected: false },
            { index: 21, title: 'Посудомоеч. маш. (хол.вода)', selected: false },
            { index: 22, title: 'Прачечная (двиг. обор.)', selected: false },
            { index: 23, title: 'Прачечная (теп. обор.)', selected: false },
            { index: 24, title: 'Рентген', selected: false },
            { index: 25, title: 'Розетки бытовые', selected: false },
            { index: 26, title: 'Розетки компьютерные', selected: false },
            { index: 27, title: 'Рукосушитель', selected: false },
            { index: 28, title: 'Слаботоч. сист.', selected: false },
            { index: 29, title: 'Станок', selected: false },
            { index: 30, title: 'Станок (теп. обор.)', selected: false },
            { index: 31, title: 'Сценич. звук', selected: false },
            { index: 32, title: 'Сценич. мех.', selected: false },
            { index: 33, title: 'Сценич. свет', selected: false },
            { index: 34, title: 'Учеб. мастерская', selected: false },
            { index: 35, title: 'Учеб.мастерская (теп. обор.)', selected: false },
            { index: 36, title: 'Учебное обор.', selected: false },
            { index: 37, title: 'Учебное обор.(теп. обор.)', selected: false },
            { index: 38, title: 'Флюорограф', selected: false },
            { index: 39, title: 'Холодильное обор.', selected: false },
            { index: 40, title: 'Холодильное обор.>30кВт', selected: false },
            { index: 41, title: 'Квартира (прир. газ)', selected: false },
            { index: 42, title: 'Квартира (сжиж. газ)', selected: false },
            { index: 43, title: 'Квартира (эл. плита)', selected: false },
            { index: 44, title: 'Дачный домик', selected: false },
            { index: 45, title: 'ИТП', selected: false }
        ],
        ppOsvSil: 0,
        ppOsvHol: 0,
        k: 0,
        k1: 0,
        pyCrash: 0,
        qyCrash: 0,
        kCrash: 0,
        ppCrash: 0,
        qpCrash: 0,
        cosfCrash: 0,
        tgfCrash: 0,
        spCrash: 0,
        ipCrash: 0,
        pyFire: 0,
        qyFire: 0,
        kFire: 0,
        ppFire: 0,
        qpFire: 0,
        cosfFire: 0,
        tgfFire: 0,
        spFire: 0,
        ipFire: 0
    }
}

export default {
    data() {        
        return {
            ...initialState(),
            institution_6_11: [
                {
                    type: 1,
                    title: 'Предприятия торговли и общественного питания, гостиницы' 
                },
                {
                    type: 2,
                    title: 'Общеобразовательные школы, специальные учебные заведения, профтехучилища' 
                },
                {
                    type: 3,
                    title: 'Детские ясли-сады' 
                },
                {
                    type: 4,
                    title: 'Ателье, комбинаты бытового обслуживания, химчистки с прачечными самообслуживания, парикмахерские' 
                },
                {
                    type: 5,
                    title: 'Организации и учреждения управления, финансирования и кредитования, проектные и конструкторские организации' 
                }
            ],
            institution_6_5: [
                {
                    type: 1,
                    title: 'Гостиницы, спальные корпуса и административные помещения санаториев, домов отдыха, пансионатов, турбаз, оздоровительных лагерей' 
                },
                {
                    type: 2,
                    title: 'Предприятия общественного питания, детские ясли-сады, учебно-производственные мастерские профтехучилищ' 
                },
                {
                    type: 3,
                    title: 'Организации и учреждения управления, учреждения финансирования, кредитования и государственного страхования, общеобразовательные школы, специальные учебные заведения, учебные здания профтехучилищ, предприятия бытового обслуживания, торговли, парикмахерские' 
                },
                {
                    type: 4,
                    title: 'Проектные, конструкторские организации, научно-исследовательские институты' 
                },
                {
                    type: 5,
                    title: 'Актовые залы, конференц-залы (освещение зала и президиума), спортзалы' 
                },
                {
                    type: 6,
                    title: 'Клубы и дома культуры' 
                },
                {
                    type: 7,
                    title: 'Кинотеатры' 
                }
            ],
            floors: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30]
        }
    },
    methods: {
        calculate() {
                let params = _.cloneDeep(this.params);
                
                axios.post('/api/internal/programs/master-scale/buildings-load', params)
                    .then(response => {
                        //такое присвоение параметров в данном случае не подходит - пропадает реакция на ввод данных в блоке данных для потребителей
                        //Object.assign(this.$data.params.loadTypeData, response.data.params.loadTypeData)
                        this.params.loadTypeData = response.data.params.loadTypeData
                        this.ppOsvSil = response.data.ppOsvSil;
                        this.ppOsvHol = response.data.ppOsvHol;
                        this.k = response.data.k;
                        this.k1 = response.data.k1
                        this.pyCrash = response.data.pyCrash;
                        this.qyCrash = response.data.qyCrash;
                        this.kCrash = response.data.kCrash;
                        this.ppCrash = response.data.ppCrash;
                        this.qpCrash = response.data.qpCrash;
                        this.cosfCrash = response.data.cosfCrash;
                        this.tgfCrash = response.data.tgfCrash;
                        this.spCrash = response.data.spCrash;
                        this.ipCrash = response.data.ipCrash;
                        this.pyFire = response.data.pyFire;
                        this.qyFire = response.data.qyFire;
                        this.kFire = response.data.kFire;
                        this.ppFire = response.data.ppFire;
                        this.qpFire = response.data.qpFire;
                        this.cosfFire = response.data.cosfFire;
                        this.tgfFire = response.data.tgfFire;
                        this.spFire = response.data.spFire;
                        this.ipFire = response.data.ipFire;
                        //resolve();
                    })
                    .catch(error => {
                        reject(error);
                    })
            
            //return new Promise((resolve, reject) => {})
        },
        submitForm() {
            this.calculate()
                .then(() => {
                    // Code...
                })
                .catch((error) => {
                    console.error(error)
                })
        },
        reset() {
            Object.assign(this.$data, initialState()) 
        },
        addConsumer() {
            let freeConsumer = this.getFreeConsumer();
            if(freeConsumer === undefined) return;
            this.params.loadTypeData.push(
                {   consumerTypeIndex: freeConsumer, 
                    fireInvolved: [0,1,3,4,18].includes(freeConsumer) ? false: true, 
                    fireInvolvedDisabledAttr: [0,1,3,4,18].includes(freeConsumer) ? true: false, 
                    kCEditing: false,
                    Np: 1,
                    Py: [0,4,10,40].includes(freeConsumer) ? 31 : 15,
                    Qy: 0,
                    Kc: 0,
                    Pp: 0,
                    Qp: 0,
                    cosf: 0.98,
                    tgf: 0,
                    Sp: 0,
                    Ip: 0
                }
            );            
        },
        delConsumer(obj) {
            console.log(obj);
            this.consumerTypes[obj.consumerTypeIndex].selected = false;
            //this.params.loadTypeData
            //let a = 0;
            //delete a;
            //$delete(this.params.loadTypeData,index);                        
        },
        getFreeConsumer() { //если нет свободного потребителя то вернет undefined
            for( let i = 0; i <= this.consumerTypes.length; i++ ){
                if( this.consumerTypes[i].selected ) 
                    continue;
                else {
                    this.consumerTypes[i].selected = true;
                    return this.consumerTypes[i].index;
                }
            }
        }
    },
    computed: {
        clonedLoadTypeData: function(){
            return _.cloneDeep(this.params.loadTypeData);
        }

    },
    watch: {
        clonedLoadTypeData: function(newVal, oldVal){
            if(JSON.stringify(newVal) != JSON.stringify(oldVal)){ //не подойдет для больших объемов данных
                //this.submitForm();
                this.calculate();
            }
        },
        'params.floorCount': function(){
            //this.submitForm();
            this.calculate();
        },
        'params.institutionType_6_11': function(){
            //this.submitForm();
            this.calculate();
        },
        'params.institutionType_6_5': function(){
            //this.submitForm();
            this.calculate();
        }

    },
    created() {
        this.addConsumer();
    }
}
</script>

<style scoped>
    .installation-type {
        /*width: 150px;*/
        cursor: pointer;
    }
</style>