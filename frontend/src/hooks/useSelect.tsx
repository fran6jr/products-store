import { SelectFields } from "hooks/types";

const useSelect = (): SelectFields[] => {
    const selectFields: SelectFields[] = [
        {
            inputId: "",
            value: "" as any,
            text: "Type Switcher",
        },
        {
            inputId: "DVD",
            value: "dvd",
            text: "DVD"
        },
        {
            inputId: "Furniture",
            value: "furniture",
            text: "Furniture"
        },
        {
            inputId: "Book",
            value: "book",
            text: "Book"
        }
    ]

    return selectFields;
}

export default useSelect;
