#include <iostream>

#define NULL_INT -90909090
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
	int i,hashkey;
	int* table = new int[m+1];
	//init
	for(i=0; i<m+1; i++) {
		table[i] = NULL_INT;
	}

	//filled
	//todo from 0 to mark ,round roop 30 move to front
	for(i=0; i<n; i++) {
		hashkey = data[i]%11;
		
		if(hashkey == 0) {
			hashkey++;
		}
		
		while(hashkey<m) {
			if(table[hashkey] == NULL_INT) {
				table[hashkey] = data[i];
				break;
			}
			//else
			hashkey++;
		}
	}

	for(i=1; i<m+1; i++) {
		if(table[i] == NULL_INT) {
			cout<<"NULL";
		} else {
			cout<<table[i];
		}

		if(i<m) {
			cout<<" "<<endl;
		}
	}

	return table;

}

void hashSearch(int content,int* hash_table,int m) {
	int i,key,step = 0,status=0;
	key = content%11+1;
	for(i=key,step = 1; i<m; i++,step++) {
		if(hash_table[i]==content) {
			status = 1;

			break;
		}
	}

	cout<<status<<" "<<step;
	if(status) {
		cout<<" "<<i;
	}
	cout<<endl;
}
