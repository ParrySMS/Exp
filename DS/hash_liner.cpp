#include <iostream>

#define NULL_INT 987548987
//rand
using namespace std;
int* hashInit(int m,int *data,int n);
void hashSearch(int content,int* hashTable,int n);

int main() {
	int t,m,n,k,i,j;
	int * data,* hashTable;

	cin>>t;
	while(t--) {
		cin>>m>>n;

		data = new int[n]();
		for(i=0; i<n; i++) {
			cin>>data[i];
		}

		//FROM 1 NOT 0
		hashTable = hashInit(m,data,n);

		cin>>k;
		while(k--) {
			int content;
			cin>>content;
			hashSearch(content,hashTable,m);
		}

	}

	delete [] data;
	delete [] hashTable;
	return 0;
}


int* hashInit(int m,int *data,int n) {
	int i,key,hashkey,move,di;
	int* table = new int[m];
	//init
	for(i=0; i<m; i++) {
		table[i] = NULL_INT;
	}

	//filled
	for(i=0; i<n; i++) {
		key = data[i]%11;//first time

		move = 0;
		di = 1;//offset
		hashkey = key;
		while(move++<m+1) {//avoid endless loop

			if(table[hashkey] == NULL_INT) {
				table[hashkey] = data[i];
				break;
			}
			//else mean conflick
			hashkey = (key+di) % m;
			di++;
		}
	}

	for(i=0; i<m; i++) {
		if(table[i] == NULL_INT) {
			cout<<"NULL";
		} else {
			cout<<table[i];
		}

		if(i<m-1) {
			cout<<" ";
		}
	}
	cout<<endl;

	return table;

}

void hashSearch(int content,int* hash_table,int m) {
	int i,key,step = 0,status=0,di=1;
	//di:offset
	key = content%11;
	for(i=key,step = 1; hash_table[i] != NULL_INT; step++,di++) {

		if(hash_table[i] == content) {
			status = 1;
			break;
		}
		//else mean conflick
		i = (key+di) % m;
	}

	cout<<status<<" "<<step;
	if(status) {
		cout<<" "<<i+1;
	}
	cout<<endl;
}
