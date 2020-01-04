

<template>
    <div >
        <div>
            <h2>Filter Data</h2>
            <select name="" class="form-control" id="" v-model="selectedCol">
                <option v-for="title in allTitles" :value="title">{{title}}</option>
            </select>
            <br>
            <multiselect placeholder="Pick some" v-model="checkedNames" :multiple="true" :options="removeDuplicates" v-if='!removeDuplicates.includes(" ")'>
            </multiselect>
            <br><br>
            <transition name="pop" >
                <div v-if="checkedNames.length > 0">
                    <h3 @click="navigate2">Ready for the next step !</h3>
                </div>
            </transition>
        </div>
    </div>
</template>
<style>
    .multiselect__option--highlight {
        background: #ff9003;

    }
    .multiselect__tag{
        background: #ff9003;

    }
    .multiselect__tag-icon:after{
        color: #fb570f;
    }
    .multiselect__option--highlight:after{
     background: #fb570f;
    }
    .multiselect__tag-icon:focus, .multiselect__tag-icon:hover{
        background: #fb570f;
    }
    .multiselect:focus{
        border-color:  #ff9003;
        box-shadow: 0 0 0 0.2rem #ff9003;
    }
    .multiselect--active{
        border-color:  #ff9003;
        box-shadow: 0 0 0 0.2rem #ff9003;
        border-radius: 4.8px;
    }
    .form-control:focus{
        border-color:  #ff9003;
        box-shadow: 0 0 0 0.2rem #ff9003;
    }


</style>

<script>
    import Multiselect from 'vue-multiselect'
    export default {
        components: { Multiselect },
        props:["allTitles", "dataCol", "dataRow"],
        data() {
            return {
                checkedNames: [],
                selectedCol: null,
                filteredData: [],
                finalRows: null,
            }
        },
        mounted() {
            console.log('FilterData Component mounted.')
        },
        watch: {
            allTitles: function(){
                this.checkedNames = []
            },
            selectedCol: function(){
                console.log("changed")
                this.checkedNames = []
            },
            // THIS IS THE PART WHERE WE CREATE FILTERED ROWS
            checkedNames: function(){
                this.filteredData = []
                var arr = this.dataRow
                var ray = []
                var finalRay =[]
                var i;
                var el;

                for(el=0; el< this.checkedNames.length; el++){
                    for(i=0; i < arr.length; i++){
                        ray.push(arr[i].includes(this.checkedNames[el]))
                        ;}
                    var x;
                    var stringRay = ray.map(String);
                    var last = stringRay.reduce(function(a, e, i) {
                        if (e === "true")
                            a.push(i);
                        return a;
                    }, []);
                    last.forEach(el=> {
                        finalRay.push(el)
                    })
                    ray = []
                }
                // console.log(finalRay)
                finalRay.forEach(element=> {
                    // console.log(element)
                    this.filteredData.push(arr[element])
                })
            },

            filteredData(val) {
                let obj = this.filteredData
                this.$emit('filtered-data', obj)
            }
        },
        computed: {
            removeDuplicates() {
                console.log(this.dataCol[this.selectedCol])
                return [...new Set(this.dataCol[this.selectedCol])]
            },
        },
        methods:{
            navigate2(){
                  return  this.$emit('navigate2', 'navigating')

            },
        }
    }
</script>
