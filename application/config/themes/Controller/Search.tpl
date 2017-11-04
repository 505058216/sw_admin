@${fieldName} = input('{fieldName}');
        if( !empty(${fieldName}) ){
            $where['{fieldName}'] = array('like',"%{${fieldName}}%");
        }