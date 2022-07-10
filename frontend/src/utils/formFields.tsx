import { ProductType } from '../hooks/types';

export interface ProductForm {
    type?: ProductType
    name: string
    label: string
    inputId: string
    inputType: string
    step?: string
}

export type SelectFields = {
    inputId: string
    value?: ProductType
    text: string
  }

export const formFields: ProductForm[] = [
  {
    type: "Book",
    name: 'weight',
    label: 'Weight (KG)',
    inputId: 'weight',
    inputType: 'number',
    step: "0.01",
  },
  {
    type: "DVD",
    name: 'size',
    label: 'Size (MB)',
    inputId: 'size',
    inputType: 'number',
    step: "0.01",
  },
  {
    type: "Furniture",
    name: 'height',
    label: 'Height (CM)',
    inputId: 'height',
    inputType: 'number',
    step: "0.01",
  }, 
  {
    type: "Furniture",
    name: 'width',
    label: 'Width (CM)',
    inputId: 'width',
    inputType: 'number',
    step: "0.01",
  },
  {
    type: "Furniture",
    name: 'length',
    label: 'Length (CM)',
    inputId: 'length',
    inputType: 'number',
    step: "0.01",
  },
  {
    name: "sku",
    label: "SKU",
    inputId: "sku",
    inputType: 'text',
  },
  {
    name: "name",
    label: "Name",
    inputId: "name",
    inputType: 'text',
  },
  {
    name: "price",
    label: "Price ($)",
    inputId: "price",
    inputType: 'number',
    step: "0.01",
  }
]

export const selectFields: SelectFields[] = [
  {
      inputId: "",
      value: "" as any,
      text: "Type Switcher",
  },
  {
      inputId: "Book",
      value: "Book",
      text: "Book"
  },
  {
      inputId: "DVD",
      value: "DVD",
      text: "DVD"
  },
  {
      inputId: "Furniture",
      value: "Furniture",
      text: "Furniture"
  }
]