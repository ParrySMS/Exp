#include <iostream>
using namespace std;

int id =3;
int main(){
	{
		int id = 66;
		cout<<id<<endl;
	}//end id 66
	
	//���û�д����Ű�ס ����������������main���� -- ����������66 
	cout<<id<<endl;
	return 0;
}
