export default {
    data() {
        return {
            lists: {},
            page_loading: false,
            form_data: {},
            // viewReport:{},
            option_data: {},
            search_input: {},
            grid_data: {},
            productionsData: [],
            catagory_products: [],
            product_datas: [],
            product_data: {},
            datas: {},
            vendor: [],
            stores: [],
            edit: false,
            permission: [],
            paginate_data: 0,
            paginate_data1: 0,
            sort: 'id',
            time: '',
            order: 'desc',
            pos_status: '',
            posStatus: '',
            paginate_num: 20,
            dataUrl: null,
            validate: false,
            current_page_no: 1,
            modal_loading: false,
            pagetitle: '',
            category_data: "",
            order_no: 0,
            form_data:{
                sbu_id:'',
                unit_id:'',
                subunit_id:'',
                department_id:'',
                section_id:'',
                subsection_id:'',
               employee_work_location:''
            },
            errors: null,
            aaa: '',
            dateFormat: "dd/MM/yyyy",
        }
    },
    computed: {
        isComplete: {
            cache: false,
            get: function() {
                return this.$v.form_data.$invalid;
            }
        },
        completeGridData: {
            cache: false,
            get: function() {
                return this.$v.grid_data.$invalid;
            }
        }
    },

    methods: {
        showMessage() {
            alert(this.message);
        },
        Export2Word(element, filename = ''){
            // alert('ss');
            var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
            var postHtml = "</body></html>";
            var html = preHtml+document.getElementById(element).innerHTML+postHtml;

            var blob = new Blob(['\ufeff', html], {
                type: 'application/msword'
            });

            // Specify link url
            var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);

            // Specify file name
            filename = filename?filename+'.doc':'document.doc';

            // Create download link element
            var downloadLink = document.createElement("a");

            document.body.appendChild(downloadLink);

            if(navigator.msSaveOrOpenBlob ){
                navigator.msSaveOrOpenBlob(blob, filename);
            }else{
                // Create a link to the file
                downloadLink.href = url;

                // Setting the file name
                downloadLink.download = filename;

                //triggering the function
                downloadLink.click();
            }

            document.body.removeChild(downloadLink);
        },
        print() {
            $("#incom-report").printThis({
                debug: false, // show the iframe for debugging
                importCSS: true, // import parent page css
                importStyle: false, // import style tags
                printContainer: true, // grab outer container as well as the contents of the selector
                loadCSS: "path/to/my.css", // path to additional css file - use an array [] for multiple
                pageTitle: "", // add title to print page
                removeInline: false, // remove all inline styles from print elements
                removeInlineSelector: "body *", // custom selectors to filter inline styles. removeInline must be true
                printDelay: 333, // variable print delay
                header: null, // prefix to html
                footer: null, // postfix to html
                base: false, // preserve the BASE tag, or accept a string for the URL
                formValues: true, // preserve input/form values
                canvas: false, // copy canvas elements
                doctypeString: '...', // enter a different doctype for older markup
                removeScripts: false, // remove script tags from print content
                copyTagClasses: false, // copy classes from the html & body tag
                beforePrintEvent: null, // callback function for printEvent in iframe
                beforePrint: null, // function called before iframe is filled
                afterPrint: null // function called before iframe is removed
            });
        },
        printDiv() {
            $("h3").each(function () {
              this.style.setProperty("margin", "0px", "important");
              this.style.setProperty("font-size", "1.75rem", "important");
            });
            $("h4").each(function () {
              this.style.setProperty("margin", "0px", "important");
              this.style.setProperty("font-size", "1.5rem", "important");
            });
            $("h5").each(function () {
              this.style.setProperty("margin", "0px", "important");
              this.style.setProperty("font-size", "1.25rem", "important");
            });
            $("h6").each(function () {
              this.style.setProperty("margin", "0px", "important");
              this.style.setProperty("font-size", "1rem", "important");
            });
            $(".table-bordered").each(function () {
              this.style.setProperty("border", "1px solid #dee2e6", "important");
              this.style.setProperty("padding", "5px .75rem", "important");
              this.style.setProperty("border-collapse", "collapse", "important");
            });
            $(".ths").each(function () {
              this.style.setProperty("border", "1px solid #dee2e6", "important");
              this.style.setProperty("padding", "5px 5px", "important");
              this.style.setProperty("border-collapse", "collapse", "important");
            });
            $(".text-center").each(function () {
              this.style.setProperty("text-align", "center", "important");
            });
            $(".text-right").each(function () {
              this.style.setProperty("text-align", "right", "important");
            });

            let contents = document.getElementById("printable").innerHTML;
            let frame1 = document.createElement("iframe");
            frame1.name = "frame1";
            frame1.style.position = "absolute";
            frame1.style.top = "-1000000px";
            document.body.appendChild(frame1);
            let frameDoc = frame1.contentWindow
              ? frame1.contentWindow
              : frame1.contentDocument.document
              ? frame1.contentDocument.document
              : frame1.contentDocument;
            frameDoc.document.open();
            frameDoc.document.write(
              '<html lang="en"><head><title>Gemcon Group</title>'
            );
            frameDoc.document.write(
              '<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.0.0-alpha/fullcalendar.print.min.css"/>'
            );
            frameDoc.document.write("</head><body>");
            frameDoc.document.write(contents);
            frameDoc.document.write("</body></html>");
            frameDoc.document.close();
            setTimeout(function () {
              window.frames["frame1"].focus();
              window.frames["frame1"].print();
              document.body.removeChild(frame1);
            }, 500);
            return false;
          },
        tableToExcel() {
            var uri = "data:application/vnd.ms-excel;base64,",
              template =
                '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
              base64 = function (s) {
                return window.btoa(unescape(encodeURIComponent(s)));
              },
              format = function (s, c) {
                return s.replace(/{(\w+)}/g, function (m, p) {
                  return c[p];
                });
              };
            var toExcel = document.getElementById("tblCustomers").innerHTML;
            var ctx = {
              worksheet: name || "",
              table: toExcel,
            };
            var link = document.createElement("a");
            link.download = "export.xls";
            link.href = uri + base64(format(template, ctx));
            link.click();
          },
        employeesSbu(option){
            this.sbu_id= option.id;
            this.form_data.sbu_id=option.id;
            let AllsectionData=Object.values(this.form_data.AllsectionData);
            let AllsubSectionData=Object.values(this.form_data.AllsubSectionData);
            let AllsubUnitData=Object.values(this.form_data.AllsubUnitData);
            let AllunitData=Object.values(this.form_data.AllunitData);
            let AllworkLocationData=Object.values(this.form_data.AllworkLocationData);
            let AlldepartmentData=Object.values(this.form_data.AlldepartmentData);
            let AllemployeeData=Object.values(this.form_data.AllemployeeData);

            this.form_data.unit_data=[...new Map((AllunitData.filter(obj => obj.sbu_id == option.id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
            this.form_data.sub_unit_data=[...new Map((AllsubUnitData.filter(obj => obj.sbu_id == option.id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
            this.form_data.department_data=[...new Map((AlldepartmentData.filter(obj => obj.sbu_id == option.id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
            this.form_data.section_data=[...new Map((AllsectionData.filter(obj => obj.sbu_id == option.id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
            this.form_data.sub_section_data=[...new Map((AllsubSectionData.filter(obj => obj.sbu_id == option.id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
            this.form_data.work_location_data=[...new Map((AllworkLocationData.filter(obj => obj.sbu_id == option.id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
            this.form_data.employee_data=[...new Map((AllemployeeData.filter(obj => obj.sbu_id == option.id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
        },
        employeesUnit(option){
            this.unit_id= option.id;
            this.form_data.unit_id=option.id;
            if(option.text != 'Deselect' ){
                let AllsectionData=Object.values(this.form_data.AllsectionData);
                let AllsubSectionData=Object.values(this.form_data.AllsubSectionData);
                let AllsubUnitData=Object.values(this.form_data.AllsubUnitData);
                let AllworkLocationData=Object.values(this.form_data.AllworkLocationData);
                let AlldepartmentData=Object.values(this.form_data.AlldepartmentData);
                let AllemployeeData=Object.values(this.form_data.AllemployeeData);

                let subunitDatas = AllsubUnitData.filter(obj => {
                    let keep = true;
                    keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                    keep = keep && obj.unit_id == this.form_data.unit_id;
                    }

                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.sub_unit_data=[...new Map(subunitDatas.map((item) => [item["id"], item])).values()];

                let departmentData = AlldepartmentData.filter(obj => {
                    let keep = true;
                    keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                    keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.department_data=[...new Map(departmentData.map((item) => [item["id"], item])).values()];

                let sectionData = AllsectionData.filter(obj => {
                    let keep = true;
                    keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                    keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.section_data=[...new Map(sectionData.map((item) => [item["id"], item])).values()];

                let subSectionData = AllsubSectionData.filter(obj => {
                    let keep = true;
                    keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                    keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.sub_section_data=[...new Map(subSectionData.map((item) => [item["id"], item])).values()];

                let worklocationData = AllworkLocationData.filter(obj => {
                    let keep = true;
                    keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                    keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.work_location_data=[...new Map(worklocationData.map((item) => [item["id"], item])).values()];

                let employeeata = AllemployeeData.filter(obj => {
                    let keep = true;
                    keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                    keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.employee_data=[...new Map(employeeata.map((item) => [item["id"], item])).values()];



                // this.form_data.sub_unit_data=[...new Map((AllsubUnitData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id  && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.department_data=[...new Map((AlldepartmentData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.section_data=[...new Map((AllsectionData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id&& obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.sub_section_data=[...new Map((AllsubSectionData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.work_location_data=[...new Map((AllworkLocationData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.employee_data=[...new Map((AllemployeeData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
            }else{
                this.multipleFilterData();
            }
        },
        employeesSubUnit(option){
            this.subunit_id= option.id;
            this.form_data.subunit_id=option.id;
            if(option.text != 'Deselect' ){
                let AllsectionData=Object.values(this.form_data.AllsectionData);
                let AllsubSectionData=Object.values(this.form_data.AllsubSectionData);
                let AllworkLocationData=Object.values(this.form_data.AllworkLocationData);
                let AlldepartmentData=Object.values(this.form_data.AlldepartmentData);
                let AllemployeeData=Object.values(this.form_data.AllemployeeData);

                let departmentDatas = AlldepartmentData.filter(obj => {
                    let keep = true;
                     keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                      keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    if (this.form_data.subunit_id) {
                      keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.department_data=[...new Map(departmentDatas.map((item) => [item["id"], item])).values()];

                let sectionDatas = AllsectionData.filter(obj => {
                    let keep = true;
                     keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                      keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    if (this.form_data.subunit_id) {
                      keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
               this.form_data.section_data=[...new Map(sectionDatas.map((item) => [item["id"], item])).values()];

                let subSectionData = AllsubSectionData.filter(obj => {
                    let keep = true;
                    keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                    keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    if (this.form_data.subunit_id) {
                    keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.sub_section_data=[...new Map(subSectionData.map((item) => [item["id"], item])).values()];

            let worklocationDatas = AllworkLocationData.filter(obj => {
                let keep = true;
                 keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                if (this.form_data.unit_id) {
                  keep = keep && obj.unit_id == this.form_data.unit_id;
                }
                if (this.form_data.subunit_id) {
                  keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                }
                keep =keep && obj.text !== null || obj.text=='Deselect'
                return keep;
            });
            this.form_data.work_location_data=[...new Map(worklocationDatas.map((item) => [item["id"], item])).values()];

            let employeeDatas = AllemployeeData.filter(obj => {
                let keep = true;
                 keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                if (this.form_data.unit_id) {
                  keep = keep && obj.unit_id == this.form_data.unit_id;
                }
                if (this.form_data.subunit_id) {
                  keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                }
                keep =keep && obj.text !== null || obj.text=='Deselect'
                return keep;
            });
            this.form_data.employee_data=[...new Map(employeeDatas.map((item) => [item["id"], item])).values()];

                // this.form_data.department_data=[...new Map((AlldepartmentData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.section_data=[...new Map((AllsectionData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.sub_section_data=[...new Map((AllsubSectionData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.work_location_data=[...new Map((AllworkLocationData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.employee_data=[...new Map((AllemployeeData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
            }else{
                this.multipleFilterData();
            }
        },

        onSelectDepartment(option){
            this.department_id= option.id;
            this.form_data.department_id=option.id;
            if(option.text != 'Deselect' ){
                let AllsectionData=Object.values(this.form_data.AllsectionData);
                let sectionDatas = AllsectionData.filter(obj => {
                    let keep = true;
                    keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                    keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    if (this.form_data.subunit_id) {
                    keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.section_data=[...new Map(sectionDatas.map((item) => [item["id"], item])).values()];

            let AllsubSectionData=Object.values(this.form_data.AllsubSectionData);
            let subSectionData = AllsubSectionData.filter(obj => {
                let keep = true;
                 keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                if (this.form_data.unit_id) {
                  keep = keep && obj.unit_id == this.form_data.unit_id;
                }
                if (this.form_data.subunit_id) {
                  keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                }
                if (this.form_data.department_id) {
                    keep = keep && obj.dep_id == this.form_data.department_id;
                }
                keep =keep && obj.text !== null || obj.text=='Deselect'
                return keep;
            });
            this.form_data.sub_section_data=[...new Map(subSectionData.map((item) => [item["id"], item])).values()];

            let AllworkLocationData=Object.values(this.form_data.AllworkLocationData);
            let workLocationData = AllworkLocationData.filter(obj => {
                let keep = true;
                 keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                if (this.form_data.unit_id) {
                  keep = keep && obj.unit_id == this.form_data.unit_id;
                }
                if (this.form_data.subunit_id) {
                  keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                }
                if (this.form_data.department_id) {
                    keep = keep && obj.dep_id == this.form_data.department_id;
                }
                keep =keep && obj.text !== null || obj.text=='Deselect'
                return keep;
            });
            this.form_data.work_location_data=[...new Map(workLocationData.map((item) => [item["id"], item])).values()];

            let AllemployeeData=Object.values(this.form_data.AllemployeeData);
            let employeeDatas = AllemployeeData.filter(obj => {
                let keep = true;
                 keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                if (this.form_data.unit_id) {
                  keep = keep && obj.unit_id == this.form_data.unit_id;
                }
                if (this.form_data.subunit_id) {
                  keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                }
                if (this.form_data.department_id) {
                    keep = keep && obj.dep_id == this.form_data.department_id;
                }
                keep =keep && obj.text !== null || obj.text=='Deselect'
                return keep;
              });
            this.form_data.employee_data=[...new Map(employeeDatas.map((item) => [item["id"], item])).values()];
                // this.form_data.section_data=[...new Map((AllsectionData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id  && obj.dep_id == this.form_data.department_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.sub_section_data=[...new Map((AllsubSectionData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id && obj.dep_id == this.form_data.department_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.work_location_data=[...new Map((AllworkLocationData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id && obj.dep_id == this.form_data.department_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.employee_data=[...new Map((AllemployeeData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id && obj.dep_id == this.form_data.department_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
            }else{
                this.multipleFilterData();
            }
        },

        employeesSection(option){
            this.section_id= option.id;
            this.form_data.section_id=option.id;
            if(option.text != 'Deselect' ){
                let AllsubSectionData=Object.values(this.form_data.AllsubSectionData);
                let subSectionData = AllsubSectionData.filter(obj => {
                    let keep = true;
                    keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                    keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    if (this.form_data.subunit_id) {
                    keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                    }
                    if (this.form_data.department_id) {
                    keep = keep && obj.dep_id == this.form_data.department_id;
                    }
                    if (this.form_data.section_id) {
                        keep = keep && obj.section_id == this.form_data.section_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.sub_section_data=[...new Map(subSectionData.map((item) => [item["id"], item])).values()];

                let AllworkLocationData=Object.values(this.form_data.AllworkLocationData);
                let workLocationData = AllworkLocationData.filter(obj => {
                    let keep = true;
                    keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                    keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    if (this.form_data.subunit_id) {
                    keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                    }
                    if (this.form_data.department_id) {
                    keep = keep && obj.dep_id == this.form_data.department_id;
                    }
                    if (this.form_data.section_id) {
                        keep = keep && obj.section_id == this.form_data.section_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.work_location_data=[...new Map(workLocationData.map((item) => [item["id"], item])).values()];

                let AllemployeeData=Object.values(this.form_data.AllemployeeData);
                let employeeDatas = AllemployeeData.filter(obj => {
                    let keep = true;
                    keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                    keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    if (this.form_data.subunit_id) {
                    keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                    }
                    if (this.form_data.department_id) {
                    keep = keep && obj.dep_id == this.form_data.department_id;
                    }
                    if (this.form_data.section_id) {
                        keep = keep && obj.section_id == this.form_data.section_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.employee_data=[...new Map(employeeDatas.map((item) => [item["id"], item])).values()];

                // this.form_data.sub_section_data=[...new Map((AllsubSectionData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id && obj.dep_id == this.form_data.department_id && obj.section_id == this.form_data.section_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.work_location_data=[...new Map((AllworkLocationData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id && obj.dep_id == this.form_data.department_id && obj.section_id == this.form_data.section_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.employee_data=[...new Map((AllemployeeData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id && obj.dep_id == this.form_data.department_id && obj.section_id == this.form_data.section_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
            }else{
                this.multipleFilterData();
            }
        },

        employeesSubSection(option){
            this.subsection_id= option.id;
            this.form_data.subsection_id=option.id;
            if(option.text != 'Deselect' ){
                let AllworkLocationData=Object.values(this.form_data.AllworkLocationData);
                let workLocationData = AllworkLocationData.filter(obj => {
                    let keep = true;
                    keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                    keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    if (this.form_data.subunit_id) {
                    keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                    }
                    if (this.form_data.department_id) {
                    keep = keep && obj.dep_id == this.form_data.department_id;
                    }
                    if (this.form_data.section_id) {
                        keep = keep && obj.section_id == this.form_data.section_id;
                    }
                    if (this.form_data.subsection_id) {
                        keep = keep && obj.sub_section_id == this.form_data.subsection_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.work_location_data=[...new Map(workLocationData.map((item) => [item["id"], item])).values()];

                let AllemployeeData=Object.values(this.form_data.AllemployeeData);
                let employeeDatas = AllemployeeData.filter(obj => {
                    let keep = true;
                    keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                    if (this.form_data.unit_id) {
                    keep = keep && obj.unit_id == this.form_data.unit_id;
                    }
                    if (this.form_data.subunit_id) {
                    keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                    }
                    if (this.form_data.department_id) {
                    keep = keep && obj.dep_id == this.form_data.department_id;
                    }
                    if (this.form_data.section_id) {
                        keep = keep && obj.section_id == this.form_data.section_id;
                    }
                    if (this.form_data.subsection_id) {
                        keep = keep && obj.sub_section_id == this.form_data.subsection_id;
                    }
                    keep =keep && obj.text !== null || obj.text=='Deselect'
                    return keep;
                });
                this.form_data.employee_data=[...new Map(employeeDatas.map((item) => [item["id"], item])).values()];

                // this.form_data.work_location_data=[...new Map((AllworkLocationData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id && obj.dep_id == this.form_data.department_id && obj.section_id == this.form_data.section_id && obj.sub_section_id == this.form_data.subsection_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
                // this.form_data.employee_data=[...new Map((AllemployeeData.filter(obj => obj.sbu_id ==  this.form_data.sbu_id && obj.unit_id == this.form_data.unit_id && obj.sub_unit_id == this.form_data.subunit_id && obj.dep_id == this.form_data.department_id && obj.section_id == this.form_data.section_id && obj.sub_section_id == this.form_data.subsection_id && obj.text !== null || obj.text=='Deselect')).map((item) => [item["id"], item])).values()];
            }else{
                this.multipleFilterData();
            }
        },

        employeesWorkLocation(option){
            this.employee_work_location= option.id;
            this.form_data.employee_work_location=option.id;
            if(option.text != 'Deselect' ){
                let AllemployeeData=Object.values(this.form_data.AllemployeeData);
            let employeeDatas = AllemployeeData.filter(obj => {
                let keep = true;
                 keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                if (this.form_data.unit_id) {
                  keep = keep && obj.unit_id == this.form_data.unit_id;
                }
                if (this.form_data.subunit_id) {
                  keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                }
                if (this.form_data.department_id) {
                  keep = keep && obj.dep_id == this.form_data.department_id;
                }
                if (this.form_data.section_id) {
                    keep = keep && obj.section_id == this.form_data.section_id;
                }
                if (this.form_data.subsection_id) {
                    keep = keep && obj.sub_section_id == this.form_data.subsection_id;
                }
                if (this.form_data.employee_work_location) {
                    keep = keep && obj.work_id == this.form_data.employee_work_location;
                }
                keep =keep && obj.text !== null || obj.text=='Deselect'
                return keep;
              });
            this.form_data.employee_data=[...new Map(employeeDatas.map((item) => [item["id"], item])).values()];
            }else{
                this.multipleFilterData();
            }
        },

        multipleFilterData(){
            let AllunitData=Object.values(this.form_data.AllunitData);
            let unitData = AllunitData.filter(obj => {
                let keep = true;
                 keep =keep && obj.sbu_id ==  this.form_data.sbu_id;
                 keep =keep && obj.text !== null || obj.text=='Deselect'
                return keep;
            });
            this.form_data.unit_data=[...new Map(unitData.map((item) => [item["id"], item])).values()];


            let AllsubUnitData=Object.values(this.form_data.AllsubUnitData);
            let subunitDatas = AllsubUnitData.filter(obj => {
                let keep = true;
                 keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                if (this.form_data.unit_id) {
                  keep = keep && obj.unit_id == this.form_data.unit_id;
                }

                keep =keep && obj.text !== null || obj.text=='Deselect'
                return keep;
            });
            this.form_data.sub_unit_data=[...new Map(subunitDatas.map((item) => [item["id"], item])).values()];

            let AlldepartmentData=Object.values(this.form_data.AlldepartmentData);
            let departmentDatas = AlldepartmentData.filter(obj => {
                let keep = true;
                 keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                if (this.form_data.unit_id) {
                  keep = keep && obj.unit_id == this.form_data.unit_id;
                }
                if (this.form_data.subunit_id) {
                  keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                }

                keep =keep && obj.text !== null || obj.text=='Deselect'
                return keep;
            });
            this.form_data.department_data=[...new Map(departmentDatas.map((item) => [item["id"], item])).values()];


            let AllsectionData=Object.values(this.form_data.AllsectionData);
            let sectionDatas = AllsectionData.filter(obj => {
                let keep = true;
                 keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                if (this.form_data.unit_id) {
                  keep = keep && obj.unit_id == this.form_data.unit_id;
                }
                if (this.form_data.subunit_id) {
                  keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                }
                if (this.form_data.department_id) {
                  keep = keep && obj.dep_id == this.form_data.department_id;
                }

                keep =keep && obj.text !== null || obj.text=='Deselect'
                return keep;
            });
            this.form_data.section_data=[...new Map(sectionDatas.map((item) => [item["id"], item])).values()];

            let AllsubSectionData=Object.values(this.form_data.AllsubSectionData);
            let subSectionData = AllsubSectionData.filter(obj => {
                let keep = true;
                 keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                if (this.form_data.unit_id) {
                  keep = keep && obj.unit_id == this.form_data.unit_id;
                }
                if (this.form_data.subunit_id) {
                  keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                }
                if (this.form_data.department_id) {
                  keep = keep && obj.dep_id == this.form_data.department_id;
                }
                if (this.form_data.section_id) {
                    keep = keep && obj.section_id == this.form_data.section_id;
                }
                keep =keep && obj.text !== null || obj.text=='Deselect'
                return keep;
            });
            this.form_data.sub_section_data=[...new Map(subSectionData.map((item) => [item["id"], item])).values()];

            let AllworkLocationData=Object.values(this.form_data.AllworkLocationData);
            let workLocationData = AllworkLocationData.filter(obj => {
                let keep = true;
                 keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                if (this.form_data.unit_id) {
                  keep = keep && obj.unit_id == this.form_data.unit_id;
                }
                if (this.form_data.subunit_id) {
                  keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                }
                if (this.form_data.department_id) {
                  keep = keep && obj.dep_id == this.form_data.department_id;
                }
                if (this.form_data.section_id) {
                    keep = keep && obj.section_id == this.form_data.section_id;
                }
                if (this.form_data.subsection_id) {
                    keep = keep && obj.sub_section_id == this.form_data.subsection_id;
                }
                keep =keep && obj.text !== null || obj.text=='Deselect'
                return keep;
            });
            this.form_data.work_location_data=[...new Map(workLocationData.map((item) => [item["id"], item])).values()];

            let AllemployeeData=Object.values(this.form_data.AllemployeeData);
            let employeeDatas = AllemployeeData.filter(obj => {
                let keep = true;
                 keep =keep && obj.sbu_id ==  this.form_data.sbu_id
                if (this.form_data.unit_id) {
                  keep = keep && obj.unit_id == this.form_data.unit_id;
                }
                if (this.form_data.subunit_id) {
                  keep = keep && obj.sub_unit_id == this.form_data.subunit_id;
                }
                if (this.form_data.department_id) {
                  keep = keep && obj.dep_id == this.form_data.department_id;
                }
                if (this.form_data.section_id) {
                    keep = keep && obj.section_id == this.form_data.section_id;
                }
                if (this.form_data.subsection_id) {
                    keep = keep && obj.sub_section_id == this.form_data.subsection_id;
                }
                if (this.form_data.employee_work_location) {
                    keep = keep && obj.work_id == this.form_data.employee_work_location;
                }
                keep =keep && obj.text !== null || obj.text=='Deselect'
                return keep;
              });
            this.form_data.employee_data=[...new Map(employeeDatas.map((item) => [item["id"], item])).values()];

        //     this.form_data.employee_data=[...new Map((AllemployeeData.filter(
        //         obj => obj.sbu_id ==  this.form_data.sbu_id &&
        //         obj.unit_id == this.form_data.unit_id &&
        //         obj.sub_unit_id == this.form_data.subunit_id &&
        //         obj.dep_id == this.form_data.department_id &&
        //         obj.section_id == this.form_data.section_id  &&
        //         obj.work_id == this.form_data.employee_work_location &&
        //         obj.text !== null || obj.text=='Deselect'
        //         )).map((item) => [item["id"], item])).values()];
        },

        showModal() {
            this.$modal.show('myModal');
        },
        hideModal() {
            this.$modal.hide('myModal');
        },
        emphideModal() {
            this.$modal.hide("EmpmyModal");
            this.userresetModal();
        },

        reload() {
            this.$router.go();
        },
        onChange(event) {
            this.page_loading = false;
            let paginate = event.target.value;
            this.getResults();

            // this.getModalDataProduction1();
            // this.getModalDataProduction2();

        },
        AccessDenied(event, values) {
            var msg = 'Sorry! ' + values;
            this.showToster({ status: 0, message: msg });
        },
        isObject(v) {
            return (typeof v === 'object') ? true : false;
        },
        onFileSelected(event) {
            let file = event.target.files[0];

            if (file.size > 1048770) {
                this.showToster({ status: 0, message: "Image size is big" });
            } else {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.form_data.photo = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        


        // add(addUrl,callback){
        //   // var form_data=this.form_data.this.imageData
        //   this.modal_loading= false;
        //   axios.post(URL.baseUrl(addUrl.add),this.form_data)
        //   .then(res => {
        //     if(res.data.status==1){
        //       // this.showToster(res.data);
        //       if(!this.form_data.id){
        //         this.modal_loading= true;
        //         this.formReset();
        //         this.getResults(1);
        //         this.hideModal();
        //         // this.getAccountCollection();
        //         // this.showToster(res.data);
        //       }else{

        //         this.modal_loading= true;
        //         this.hideModal();
        //         this.getResults(this.current_page_no);
        //       }
        //       // this.showToster(res.data);
        //     }
        //     this.errors =null;
        //     this.modal_loading= true;
        //     this.showToster(res.data);
        //     if(callback){
        //       callback();
        //     }
        //   })
        //   .catch(error => {
        //     if(error.response.status == 422){
        //       this.errors = error.response.data.errors;
        //     }
        //     this.modal_loading= true;
        //     // this.hideModal();
        //     var msg = 'opps! something went wrong';
        //     this.showToster({status:0,message:msg});
        //   });
        // },
        add(addUrl, callback) {

            $('.btn-disabled').attr('disabled', 'disabled');
            this.modal_loading = false;
            this.page_loading = false;
            axios.post(URL.baseUrl(addUrl.add), this.form_data)
                .then(res => {
                    $('.btn-disabled').removeAttr('disabled', 'disabled');
                    if (res.data.status == 1) {
                        this.showToster(res.data);
                        this.getResults();
                        if (!this.form_data.id) {
                            // this.formReset();
                            if (this.$route.params.folderId) {
                                this.getResults(1, this.$route.params.folderId);
                            } else {
                                this.getResults(1);
                            }
                            this.hideModal();
                            this.emphideModal();
                            // var functionString = "emphideModal"
                            // eval("typeof " + functionString)
                            if(typeof emphideModal == 'function'){
                            this.emphideModal();
                            }

                            this.page_loading = true;
                            this.modal_loading=true;
                        } else {
                            this.modal_loading = true;
                            this.page_loading = true;
                            this.hideModal();
                            this.emphideModal();
                            // this.emphideModal();
                            // var functionString = "emphideModal"
                            if(typeof emphideModal == 'function'){
                                this.emphideModal();
                                }
                            if (this.$route.params.folderId) {
                                this.getResults(1, this.$route.params.folderId);
                            } else {
                                this.getResults(this.current_page_no);
                            }
                        }
                        this.page_loading = true;
                        this.modal_loading=true;
                    }
                    // this.showToster(res.data);
                    this.modal_loading = true;
                    this.errors = null;

                    this.getResults(1);
                    if (callback) {
                        callback();
                    }
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    this.page_loading = true;
                    this.modal_loading=true;
                    // this.hideModal();
                    $('.btn-disabled').removeAttr('disabled', 'disabled');
                    var msg = 'opps! something went wrong';
                    this.showToster({ status: 0, message: msg });
                });
        },

        formReset() {
            this.form_data = {};
        },
        showToster(info) {
            if (info.status == 1) {
                this.$toast.success({
                    title: 'Success!',
                    message: info.message
                });
            } else {
                if (typeof info.message === 'object') {
                    this.errors = info.message;
                    var msg = 'opps! something went wrong';
                } else {
                    var msg = info.message;
                }
                this.$toast.error({
                    title: 'Error!',
                    message: msg
                });
            }
        },

        deleteItem(deleteUrl) {
            if (!window.confirm('Are you sure want to delete..')) {
                return;
            }

            // .then((result) => {
            // if(result.value) {
            axios.delete(URL.baseUrl(deleteUrl.delUrl))
                .then(res => {
                    this.showToster(res.data);
                    // this.showToster({status:1,message:'You successfully deleted this file'});
                    if (Object.keys(this.paginate_data.data).length > 1) {
                        this.getResults(this.current_page_no);
                    } else {
                        this.getResults(this.current_page_no - 1);
                    }
                })
                .catch(error => {
                    // handle error
                    this.showToster({ status: 0, message: 'Opps something went wrong' });
                })

        },
        approveItem(deleteUrl) {
            axios.delete(URL.baseUrl(deleteUrl.delUrl))
                .then(res => {
                    this.showToster({ status: 1, message: 'You successfully approve this file' });
                    if (Object.keys(this.paginate_data.data).length > 1) {
                        this.getResults(this.current_page_no);
                    } else {
                        this.getResults(this.current_page_no - 1);
                    }
                })
                .catch(error => {
                    this.showToster({ status: 0, message: 'Opps something went wrong' });
                })
        },


        // deleteItem(deleteUrl){

        //   this.$swal({
        //     title: 'Are you sure?',
        //     text: 'You can\'t revert your action',
        //     type: 'warning',
        //     showCancelButton: true,
        //     confirmButtonText: 'Yes Delete it!',
        //     cancelButtonText: 'No, Keep it!',
        //     showCloseButton: true,
        //     showLoaderOnConfirm: true
        //   }).then((result) => {
        //     if(result.value) {
        //       axios.delete(URL.baseUrl(deleteUrl.delUrl))
        //       .then(res => {
        //         this.$swal('Deleted', 'You successfully deleted this file', 'success');
        //         if(Object.keys(this.paginate_data.data).length > 1){
        //           this.getResults(this.current_page_no);
        //         }else{
        //           this.getResults(this.current_page_no - 1);
        //         }
        //       })
        //       .catch(error => {
        //         // handle error
        //         this.showToster({status:0,message:'Opps something went wrong'});
        //       })
        //     } else {
        //       this.$swal('Cancelled', 'Your file is still intact', 'info')
        //     }
        //   });
        // },



        // getResults(page){
        getResults(page, page_ref_id = false) {
        //    alert(page_ref_id);
            if (page_ref_id) {
                page_ref_id = page_ref_id;
            } else if (this.$route.params.jobId) {
                page_ref_id = this.$route.params.jobId;
            } else {
                page_ref_id = '';
            }

            if (typeof page === 'undefined') {
                page = 1;
            }

            var obj_params = {
                paginate_num: this.paginate_num,
                page: page,
                sort: this.sort,
                order: this.order,
                page_ref_id: page_ref_id
            };
            var data_params = Object.assign(this.search_input,this.search_inpu_all, obj_params);
            var fetchUrl = this.$route.meta.fetchUrl;
            this.current_page_no = page;
            axios.get(URL.baseUrl(fetchUrl), {
                    params: data_params
                })
                .then(res => {
                    if (res.data.status == 'logout') {
                        window.location.href = res.data.url;
                    } else {
                        this.lists = res.data;
                        this.pos_status = res.data.pos_status;
                        this.form_data = res.data;
                        this.paginate_data = res.data.paginate_data;
                        this.paginate_data1 = res.data.paginate_data1;
                        this.permission = res.data.permission;
                        this.paginate_data_2nd = res.data.paginate_data_2nd;
                        this.transfer = res.data.transfer;
                        this.company = res.data.company;
                        this.vendors = res.data.vendors;
                        this.stores = res.data.stores;
                        this.category_data = res.data.category_data;
                        this.all_voucher_lists = res.data.all_voucher_lists;
                        this.catagory_products = res.data;
                        this.temporary_pric = res.data.temporary_pric;
                        this.temporary_cart = res.data.temporary_cart;

                        this.cards = res.data.cards;

                        this.option_data = res.data;


                        if (res.data.pos_status == 0) {
                            this.showModal();
                        }

                        if (res.data.formData) {
                            this.form_data = res.data.formData;
                            //this.option_data = res.data.formData;
                        }
                        if (res.data.search_input) {
                            this.search_input = res.data.search_input;
                        }
                        this.pagetitle = res.data.pagetitle;
                    }
                    if (page > 1) {
                        this.order_no = this.paginate_num * (page - 1);
                    } else {
                        this.order_no = 0;
                    }
                    this.page_loading = true;
                    this.modal_loading=true;
                })

            .catch(error => {
                this.showToster({ status: 0, message: 'opps! something went wrong' });
                this.page_loading = true;
            })
        },
        update(addUrl) {
            if (this.invoice_number) {
                var invoice_number = this.invoice_number;
            } else {
                var invoice_number = '';
            }

            if (this.po_id) {
                var po_id = this.po_id;
            } else {
                var po_id = '';
            }
            if (this.types) {
                var types = this.types;
            } else {
                var types = '';
            }
            axios.post(URL.baseUrl(addUrl.add), {
                    supplierName: this.productionsData,
                    product_datas: this.product_datas,
                    po_id: po_id,
                    invoice_number: invoice_number,
                    types: types,
                }).then(res => {
                    if (res.data.status == 1) {

                        if (!this.form_data.id) {
                            this.formReset();
                            this.getResults(1);
                            this.getModalDataProduction1();
                            // this.getModalDataProduction2();
                            this.OrderCancel();
                            this.hideProductionsModel();
                            this.hideProductionsModel1();
                        } else {
                            this.hideModal();
                            this.getResults(this.current_page_no);
                            this.getModalDataProduction1();
                            // this.getModalDataProduction2();
                            this.OrderCancel();
                            this.hideProductionsModel();
                            this.hideProductionsModel1();
                        }
                    }
                    this.errors = null;
                    this.showToster(res.data);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    var msg = 'opps! something went wrong';
                    this.showToster({ status: 0, message: msg });
                });
        },


        getModalDataProduction(event, obj, callback) {
            this.showProductionsModel();
            this.hideProductionsModel1();
            if (obj && obj.dataUrl) {
                this.modal_loading = false;
                axios.get(URL.baseUrl(obj.dataUrl))
                    .then(res => {
                        this.productionsData = res.data.edit_data;
                        this.product_datas = res.data.product_data;
                        this.types = res.data.type;
                        this.po_id = res.data.po_id;
                        this.invoice_number = res.data.invoice_number;
                        this.allitems = res.data.items;
                        this.vendor = res.data.vendor;
                        this.stores = res.data.stores;
                        this.option_data = res.data;
                        this.modal_loading = true;
                        this.errors = null;
                        // this.getModalDataProduction1();
                        if (!this.form_data.id) {
                            if (callback) {
                                callback();
                            }
                            this.formReset();
                            this.getResults(1);
                        } else {
                            if (callback) {
                                callback();
                            }
                        }
                    })
                    .catch(error => {
                        this.showToster({ status: 0, message: 'opps! something went wrong' });
                        this.modal_loading = true;
                    })

            } else {
                this.form_data = {};
                this.modal_loading = true;
            }
        },
        showProductionsModel() {
            this.$modal.show('myModal1');
            //   this.id = this.$el.getAttribute('data-id');
        },
        hideProductionsModel() {
            this.$modal.hide('myModal1');
        },
        showProductionsModel1() {
            this.$modal.show('myModal2');
            //   this.id = this.$el.getAttribute('data-id');
        },
        // myModal2
        hideProductionsModel1() {
            this.$modal.hide('myModal2');
        },


        getModalDataProduction1(event, obj, callback) {
            this.showProductionsModel1();

            if (obj && obj.dataUrl) {
                this.modal_loading = false;
                axios.get(URL.baseUrl(obj.dataUrl))
                    .then(res => {
                        this.datas = res.data;
                        this.productionsData = res.data.edit_data;
                        this.product_datas = res.data.product_data;
                        this.vendors = res.data.vendors;
                        this.time = res.data.time;
                        this.stores = res.data.stores;
                        this.billList = res.data.billList;
                        this.billDetails = res.data.billDetails;
                        this.shipping = res.data.shipping;
                        this.RefNo = res.data.RefNo;
                        this.termsAndCondition = res.data.termsAndCondition;
                        this.type = res.data.type;
                        this.option_data = res.data;
                        this.modal_loading = true;
                        this.errors = null;
                        if (!this.form_data.id) {
                            this.formReset();
                            this.getResults(1);
                            // this.getModalDataProduction2();
                        } else {
                            this.hideModal();
                            // this.getModalDataProduction2();
                            this.getResults(this.current_page_no);
                        }
                    })
                    .catch(error => {
                        this.showToster({ status: 0, message: 'opps! something went wrong' });
                        this.modal_loading = true;
                    })

            } else {
                this.form_data = {};
                this.modal_loading = true;
            }
        },

        OrderCancel(event, obj, callback) {
            this.getModalDataProduction1();
            if (obj && obj.dataUrl) {
                this.modal_loading = false;
                axios.get(URL.baseUrl(obj.dataUrl))
                    .then(res => {
                        if (res.data.status == 1) {
                            this.hideProductionsModel1();
                        }
                        this.showToster(res.data);
                        this.errors = null;
                        this.getResults(1);
                        this.getModalDataProduction1();
                        // this.getModalDataProduction2();
                        this.hideProductionsModel();
                        this.hideProductionsModel1();

                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                        var msg = 'opps! something went wrong';
                        this.showToster({ status: 0, message: msg });
                    });
            }
        },



        getModalData(event, obj, callback) {
            if (this.types == undefined) {
                this.showModal();
            } else if (this.types == false) {
                this.showModal();
                this.temporary_pric.get_pey = this.temporary_pric.total_pay;
            } else {
                this.showModal();
            }

            if (obj && obj.dataUrl) {
                this.modal_loading = false;
                axios.get(URL.baseUrl(obj.dataUrl))

                .then(res => {
                        if (res.data.status == 0) {
                            this.showToster(res.data);

                            // this.form_data = res.data;
                        }
                        this.types = 1,
                        this.types = true,
                        this.form_data = res.data;
                        this.form = res.data;
                        this.option_data = res.data;
                        this.item_unit = res.data.item_unit;
                        this.items = res.data.items;
                        this.r_items = res.data.r_items;
                        this.Branch = res.data.Branch;
                        this.posStatus = res.data.posStatus,
                            //  this.lists.pos_status=1;
                            //  this.lists.posStatus='';
                            //  this.lists.pos_status = res.data.pos_status;
                            //  this.OpeingAmount = res.data.OpeingAmount;
                            this.OpeingItems = res.data.OpeingItems;
                        this.termsAndCondition = res.data.termsAndCondition;
                        this.modal_loading = true;
                        this.errors = null;
                        this.pos_status = res.data.pos_status;
                        // this.showToster(res.data);
                        // this.getAccountCollection();
                        if (!this.form_data.id) {
                            if (callback) {
                                callback();
                            }

                        } else {
                            if (callback) {
                                callback();
                            }
                        }

                    })
                    .catch(error => {
                        this.showToster({ status: 0, message: 'opps! something went wrong' });
                        this.modal_loading = true;
                    })

            } else {
                this.form_data = {};
                this.modal_loading = true;
            }
        },
        EmpgetModalData(event, obj, callback) {
            if (this.types == undefined) {
                this.$modal.show('EmpmyModal');
            } else if (this.types == false) {
                this.$modal.show('EmpmyModal');
                this.temporary_pric.get_pey = this.temporary_pric.total_pay;
            } else {
                this.$modal.show('EmpmyModal');
            }

            if (obj && obj.dataUrl) {
                this.modal_loading = false;
                axios.get(URL.baseUrl(obj.dataUrl))

                .then(res => {
                        if (res.data.status == 0) {
                            this.showToster(res.data);

                            // this.form_data = res.data;
                        }
                        this.types = 1,
                            this.types = true,

                            this.form_data = res.data;
                        this.option_data = res.data;
                        this.item_unit = res.data.item_unit;
                        this.items = res.data.items;
                        this.r_items = res.data.r_items;
                        this.Branch = res.data.Branch;
                        this.posStatus = res.data.posStatus,
                            //  this.lists.pos_status=1;
                            //  this.lists.posStatus='';
                            //  this.lists.pos_status = res.data.pos_status;
                            //  this.OpeingAmount = res.data.OpeingAmount;
                            this.OpeingItems = res.data.OpeingItems;
                        this.termsAndCondition = res.data.termsAndCondition;
                        this.modal_loading = true;
                        this.errors = null;
                        this.pos_status = res.data.pos_status;
                        // this.getAccountCollection();
                        if (!this.form_data.id) {
                            if (callback) {
                                callback();
                            }

                        } else {
                            if (callback) {
                                callback();
                            }
                        }
                    })
                    .catch(error => {
                        this.showToster({ status: 0, message: 'opps! something went wrong' });
                        this.modal_loading = true;
                    })

            } else {
                this.form_data = {};
                this.modal_loading = true;
            }
        },



        getModalDataView(event, obj, callback) {
            this.showModal();
            this.types = 2;
            if (obj && obj.dataUrl) {
                this.modal_loading = false;
                axios.get(URL.baseUrl(obj.dataUrl))
                    .then(res => {
                        this.form_data = res.data;
                        this.option_data = res.data;
                        this.item_unit = res.data.item_unit;
                        this.items = res.data.items;
                        this.Branch = res.data.Branch;
                        this.modal_loading = true;
                        this.errors = null;
                        if (!this.form_data.id) {
                            if (callback) {
                                callback();
                            }
                        } else {
                            if (callback) {
                                callback();
                            }
                        }
                    })
                    .catch(error => {
                        this.showToster({ status: 0, message: 'opps! something went wrong' });
                        this.modal_loading = true;
                    })

            } else {
                this.form_data = {};
                this.modal_loading = true;
            }
        },
        sortingChanged(column) {
            if (this.sort != column) {
                this.order = 'asc';
            } else {
                if (this.order == 'asc') this.order = 'desc';
                else this.order = 'asc';
            }
            this.sort = column;
            this.getResults();
        },
        getSortingClass(column) {
            if (this.sort == column) {
                return (this.order == 'asc') ? 'asc' : 'desc';
            }
        },
        gridAdd(event, input) {
            event.preventDefault();
            /*let objCopy = Object.assign({}, input);
            this.form_data.details_data.push(objCopy);*/
            this.form_data.details_data.push(input);
            this.grid_data = {};
        },
        gridEdit(event, input) {
            event.preventDefault();
            this.grid_data = input;
            var index = this.form_data.details_data.indexOf(input);
            this.form_data.details_data.splice(index, 1);
        },
        gridRemove(event, data) {
            event.preventDefault();
        },
        viewReport(formdata, rUrl) {

            var urlParam = "";
            var Url = "";
            if (Object.keys(formdata).length > 0) {
                for (let key in formdata) {
                    urlParam += ((urlParam == "") ? "?" : "&") + key + "=" + formdata[key];
                }
            }
            if (rUrl) {
                Url = rUrl;
            } else {
                Url = this.$route.meta.reportUrl;
            }
            var width = $(document).width();
            var height = $(document).height();
            var myWindow = window.open(URL.baseUrl(Url + urlParam), "", "width=" + width + ",height=" + height);
        }

    }
}



