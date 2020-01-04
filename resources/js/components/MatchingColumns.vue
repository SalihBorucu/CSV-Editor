<template>
    <div>
        <div>
            <h2> Match Columns</h2>
        </div>
        <div >
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Default Columns</th>
                    <th>Current Columns</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(heading, index) in Object.keys(selectedData)">
                    <td><p>{{heading}}</p>
<!--                        <input class="form-control" type="text" :placeholder="heading" :id="heading" >-->
                    <td>
                        <select name="" class="form-control" :id="heading"  v-model="selectedData[heading]"  @change="replaceTitles"  >
                            <option value="">No Value For This</option>
                            <option  v-for="(title, index) in allTitles" :key="heading + index" :id="heading"  :value="title" ><span v-once >{{title}}</span> </option>
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>
            <br>
        </div>
        <button class="btn btn-dark" @click="download_csv()">Export as CSV</button>
    </div>

</template>

<style>
    p{
        color: #fff;
    }
    table{
        display: table;
        text-align: center;
    }
    h2{
        text-align: center;
        padding-top: 15px;
    }
    td{
        text-align: center;
        vertical-align: middle;
        display: table-cell;
    }
</style>

<script>

    export default {
        mounted() {
            console.log('MatchingColumns Component mounted.')
        },
        props: ["allTitles", "filteredData1"],
        data(){
            return {
                test: [],
                currentValue: null,
                finalTitles: [],
                finalCol: {},
                selectedData: {
                    "First Name": null,
                    "Second Name": null,
                    "Address": null,
                    "Title": null,
                    "Company": null,
                    "Country": null,
                    "Industry": null,
                },
                newObj: {},
            }
        },
        watch:{
            filteredData1: function(){
                let newObjCol = {};
                this.allTitles.forEach(title => {
                    newObjCol[title] = [];
                });
                this.filteredData1.forEach(row => {
                    let arr = row;

                    this.allTitles.forEach((title, i) => {
                        newObjCol[title].push(arr[i]);
                    });
                });
                this.finalCol = newObjCol;
            },
        },
        methods: {
            // keyUpdate(ev){
            //   console.log(ev.target.value)
            //  this.selectedData[ev.target.value] = this.selectedData[ev.target.id]
            //     delete this.selectedData[ev.target.id];
            // },


            replaceTitles: function (el) {
                var selectedVal = el.target.value
                var selectedId = el.target.id
                console.log(selectedId)
                console.log(selectedVal)
                console.log(this.finalCol[selectedVal])
                if(selectedVal){
                    console.log("yess")
                    this.newObj[selectedId] = this.finalCol[selectedVal]
                } else {
                    delete this.newObj[selectedId]
                }
            },
            download_csv() {
                var cols = Object.values(this.newObj)
                var colsSep = []
                var rows = []
                if(cols){
                    cols[0].forEach((el, i)=> {
                        cols.forEach((item, x)=>{
                            colsSep.push(cols[x][i])
                        })
                        rows.push(colsSep)
                        colsSep = []
                    }  )
                }
                var csv = Object.keys(this.newObj);
                csv += "\n";
                rows.forEach(function(row) {
                    csv += row.join(',');
                    csv += "\n";
                });
                var hiddenElement = document.createElement('a');
                var csvData = new Blob([csv], { type: 'text/csv' });
                hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
                hiddenElement.href = URL.createObjectURL(csvData);
                hiddenElement.target = '_blank';
                hiddenElement.download = 'dataExport.csv';
                hiddenElement.click();
            },
        }
    }
</script>
