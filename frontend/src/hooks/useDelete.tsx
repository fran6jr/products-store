import { useState } from "react";


const baseUrl = process.env.REACT_APP_BASEURL

export const useDelete = () => {
  const [error, setError] = useState(false);
  const [loading, setLoading] = useState<boolean>()

  const deleteProducts = async (skus: string[]) => {
    setError(false);
    setLoading(true)
    try {
      const response = await fetch(`${baseUrl}/delete`,
        {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(skus)
        }
      )
      await response?.json();
    }
    catch (e) {
      console.log(JSON.stringify(e));
      setError(true);
    }
    setLoading(false)
  }

  return { error, loading, deleteProducts };

}
