@${fieldName}_start = input('{fieldName}_start');
        @${fieldName}_end = input('{fieldName}_end');
        if( !empty(${fieldName}_start) ){
            $whereDate .= ' and UNIX_TIMESTAMP({fieldName}) < '.strtotime(${fieldName}_start);
        }
        if( !empty(${fieldName}_end) ){
            $whereDate .= ' and UNIX_TIMESTAMP({fieldName}) > '.strtotime(${fieldName}_end);
        }