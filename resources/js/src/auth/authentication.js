import { userAbilities } from './userAbilities';

// Use
// can('create', 'listing') // can current user create lsiting?

const getUser = JSON.parse(localStorage.getItem("userData")) || ''
const user_Role = getUser.user_role || '';
const userRoleID = user_Role.id || ''

export function can (action, entity, user_role_Id = userRoleID,) {

    if( !userAbilities[user_role_Id] ) {
        return false
    } else {
        if ( userAbilities[user_role_Id][action].includes(entity) ) {
            return true
        } else {
            return false
        }
    }

};
