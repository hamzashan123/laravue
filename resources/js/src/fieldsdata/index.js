export const statuses_color = [
    {
        // Listing
        "draft": "Draft",
        "publish": "Published",
        // Proposal
        "pending": "Pending",
        "approved": "Approved",
        "reject": "Rejected",
        "waiting_assignment": "Waiting to Assign",
        "pre_contract": "Pre Contract",
        "withdraw": "Withdraw",
        // Contract
        "contract_assigned": "Contract Assigned",
        "contract_started": "Contract Started!",
        "contract_completed": "Completed",
        // normal status
        "active": "Active",
        "inactive": "In-active",
        "banned": "Banned",
        "unbanned": "active",
    },
    {
        // Listing
        "draft": "light-warning",
        "publish": "light-primary",
        // Proposal
        "pending": "light-danger",
        "approved": "light-success",
        "reject": "light-danger",
        "waiting_assignment": "light-warning",
        "pre_contract": "light-info",
        "withdraw": "light-danger",
        // Contract
        "contract_assigned": "primary",
        "contract_started": "info",
        "contract_completed": "success",
        // status
        "active": "success",
        "inactive": "danger",
        "banned": "danger",
        "unbanned": "success",
    },
];

export const minBudget = [
    { value: null, text: "Budget Minimum *" },
    { value: "100000", text: "1000,00" },
    { value: "1000000", text: "1000,000" },
];

export const maxBudget = [
    { value: null, text: "Budget Maximum *" },
    { value: "100500", text: "1000,500" },
    { value: "10000400", text: "10000,1400" },
];
export const state = [
    { value: null, text: "Select State" },
    { value: "state", text: "state 1" },
    { value: "state", text: "state 1" },
];
export const district = [
    { value: null, text: "Select District" },
    { value: "state", text: "state 1" },
];
