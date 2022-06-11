import { useCallback, useState, useEffect } from "react"
import { Product } from "./types"

const baseUrl = process.env.REACT_APP_BASEURL

const useProductList = (): { refetch: () => void, products: Product[] } => {
  const [products, setProducts] = useState<Product[]>([]);

  const fetchProducts = useCallback(() => {
    fetch(`${baseUrl}/list`,
    { method: 'GET' } )
      .then(response => response.json())
      .then(products => setProducts([...products]))
      .catch((e) => console.log(e));
  }, [])

  useEffect(() => {
    fetchProducts()
  }, []);

  return { refetch: fetchProducts, products };

}

export default useProductList;
