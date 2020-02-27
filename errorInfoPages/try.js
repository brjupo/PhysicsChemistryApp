var myNestedVals = {
    'Herramientas': {
        'H1': ['1.1.1', '1.1.2', '1.1.3'],
        'H2': ['1.2.1', '1.2.2', '1.2.3'],
        'H3': ['1.3.1', '1.3.2', '1.3.3']
    },
    'Vectores': {
        '2.1': ['2.1.1', '2.1.2', '2.1.3'],
        '2.2': ['2.2.1', '2.2.2', '2.2.3'],
        '2.3': ['2.3.1', '2.3.2', '2.3.3']
    },
    'MRU': {
        '3.1': ['3.1.1', '3.1.2', '3.1.3'],
        '3.2': ['3.2.1', '3.2.2', '3.2.3'],
        '3.3': ['3.3.1', '3.3.2', '3.3.3']
    }
}
function createOption(ddl, text, value) {
    var opt = document.createElement('option');
    opt.value = value;
    opt.text = text;
    ddl.options.add(opt);
}

function createOptions(optionsArray, ddl) {
    for (i = 0; i < optionsArray.length; i++) {
        createOption(ddl, optionsArray[i], optionsArray[i]);
    }
}

function configureDDL2(ddl1, ddl2, ddl3) {
    ddl2.options.length = 0;
    ddl3.options.length = 0;
    createOption(ddl2, "Pick 2nd Option", "");
    var ddl2keys = Object.keys(myNestedVals[ddl1.value]);
    createOptions(ddl2keys, ddl2)
}

function configureDDL3(ddl1, ddl2, ddl3) {
    ddl3.options.length = 0;
    createOption(ddl3, "Pick 3rd Option", "");
    var ddl3keys = myNestedVals[ddl1.value][ddl2.value];
    createOptions(ddl3keys, ddl3);
}