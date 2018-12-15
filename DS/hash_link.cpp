#include <iostream>
using namespace std;
const int MOD_NUM = 11;
const int NULL_INT = -1;
class Node {
	public:
		int data;
		Node *next;

		Node() {
			data = NULL_INT;
			next = NULL;
		}
};
void hashInit(int *data,int n,Node* hash_head);
void hashSearch(int content,Node* hash_head);
void addNode(Node* head, int data);


int main() {
	Node *hash_head;
	hash_head = new Node[MOD_NUM]();
	int n,t,i,*data;
	cin>>n;

	data = new int[n]();
	for(i=0; i<n; i++) {
		cin>>data[i];
	}
	hashInit(data,n,hash_head);
	
//	for(i=0; i<MOD_NUM; i++) {
//		cout<<i<<endl;
//		cout<<"data:"<<hash_head[i].data<<endl;
//		cout<<"next:"<<hash_head[i].next<<endl;
//	}

	cin>>t;
	while(t--) {
		int content;
		cin>>content;
		hashSearch(content,hash_head);
	}

	return 0;
}


void hashInit(int *data,int n,Node* hash_head) {
	int i,key;
	for(i=0; i<n; i++) {
		key = data[i] % MOD_NUM;
		addNode(&hash_head[key], data[i]);
	}
}

void hashSearch(int content,Node* hash_head) {
	int step,key;
	Node  *node,head;
	key = content % MOD_NUM;
	head = hash_head[key];

	for(node = head.next,step=1; node!=NULL && node->data != NULL_INT; step++) {
		if(content == node->data) {
			cout<<key<<" "<<step<<endl;
			return;
		}

		if(node->next == NULL) {
			break;
		}

		node = node->next;
	}

	cout<<"error"<<endl;

	addNode(&hash_head[key], content);
}


void addNode(Node *head, int data) {
	Node *node;
	int i;
	for(node = head; node->next!= NULL; node = node->next) {} //null exec
	node->next = new Node();
	node->next->data = data;
}
