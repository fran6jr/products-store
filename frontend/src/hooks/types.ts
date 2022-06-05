export type Product = {
  sku: string
  name: string
  price?: number
  weight?: number
  size?: number
  width?: number
  height?: number
  length?: number
  [key: string]: any
}

export type ProductType = "dvd" | "book" | "furniture"


export type SelectFields = {
  inputId: string
  value?: ProductType
  text: string
}