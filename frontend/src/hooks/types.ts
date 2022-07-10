export type Product = {
  type?: ProductType
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

export type Selected =
{ 
  sku: string;
  type: ProductType
}

export type ProductType = "Book" | "DVD" | "Furniture"