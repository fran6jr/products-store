import { useState, useEffect } from "react"
import { Product } from "./types"

const baseUrl = process.env.REACT_APP_BASEURL

const useProductList = (): Product[] => {
  const [products, setProducts] = useState<Product[]>([]);

  useEffect(() => {
    fetch(baseUrl +"/list",
    { method: 'GET',} )
      .then(response => response.json())
      .then(setProducts)
      .catch((e) => console.log(e));
  }, []);

  return products;

}

export default useProductList;
