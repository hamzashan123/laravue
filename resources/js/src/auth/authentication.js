import { userAbilities } from './userAbilities';

// Use
// can('create', 'listing') // can current user create lsiting?

function getUserRoleId() {
    const getUser = JSON.parse(localStorage.getItem("userData")) || ''
    const user_Role = getUser.user_role || '';
    const userRoleID = user_Role.id || ''
    return userRoleID
}

export function can (action, entity, user_role_Id = getUserRoleId() ) {

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
