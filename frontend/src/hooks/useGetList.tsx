import { useState, useEffect } from "react"
import { baseUrl } from "./baseUrl";
import { Product } from "./types"

const useGetList = (): Product[] => {
  const [products, setProducts] = useState<Product[]>([]);

  useEffect(() => {
    fetch(baseUrl +"/list",
    { method: 'GET',} )
      .then(response => response.json())
      .then(setProducts)
      .catch((e) => console.log(e));
  }, []);

  console.log({ products });

  return products;

}

export default useGetList;
