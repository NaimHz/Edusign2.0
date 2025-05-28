import { Camera, CameraView } from 'expo-camera';
import React, { useEffect, useState } from 'react';
import { StyleSheet, Text, TouchableOpacity, View, Alert, FlatList } from 'react-native';
import axios from 'axios';

const API_URL = 'http://10.26.135.236:8000/api';

interface Student {
    id: number;
    first_name: string;
    last_name: string;
}

function Index() {
    const [hasPermission, setHasPermission] = useState<boolean | null>(null);
    const [scanned, setScanned] = useState(false);
    const [students, setStudents] = useState<Student[]>([]);
    const [selectedStudent, setSelectedStudent] = useState<Student | null>(null);
    const [showScanner, setShowScanner] = useState(false);

    useEffect(() => {
        const getCameraPermissions = async () => {
            const { status } = await Camera.requestCameraPermissionsAsync();
            setHasPermission(status === 'granted');
        };

        getCameraPermissions();
        fetchStudents();
    }, []);

    const fetchStudents = async () => {
        try {
            const response = await axios.get(`${API_URL}/students`);
            setStudents(response.data);
        } catch (error) {
            Alert.alert('Erreur', 'Impossible de charger la liste des étudiants');
        }
    };

    const handleBarCodeScanned = async ({ data }: { data: string }) => {
        if (!selectedStudent) {
            Alert.alert('Erreur', 'Veuillez sélectionner un étudiant d\'abord');
            return;
        }

        try {
            const response = await axios.post(`${API_URL}/sessions/scan`, {
                session_qr_code: data,
                student_id: selectedStudent.id
            });
            Alert.alert('Succès', 'Présence enregistrée !');
            setScanned(true);
        } catch (error: any) {
            Alert.alert('Erreur', error.response?.data?.message || 'Impossible d\'enregistrer la présence');
        }
    };

    if (hasPermission === null) {
        return <Text>Demande d&apos;accès à la caméra...</Text>;
    }
    if (hasPermission === false) {
        return <Text>Pas d&apos;accès à la caméra</Text>;
    }

    if (showScanner) {
        return (
            <View style={styles.container}>
                <CameraView
                    style={styles.camera}
                    onBarcodeScanned={scanned ? undefined : handleBarCodeScanned}
                />
                <View style={styles.overlay}>
                    <View style={styles.scanArea} />
                </View>
                <View style={styles.buttonContainer}>
                    <TouchableOpacity
                        style={styles.button}
                        onPress={() => {
                            setScanned(false);
                            setShowScanner(false);
                        }}>
                        <Text style={styles.buttonText}>Fermer</Text>
                    </TouchableOpacity>
                    {scanned && (
                        <TouchableOpacity
                            style={styles.button}
                            onPress={() => setScanned(false)}>
                            <Text style={styles.buttonText}>Scanner à nouveau</Text>
                        </TouchableOpacity>
                    )}
                </View>
            </View>
        );
    }

    return (
        <View style={styles.mainContainer}>
            <Text style={styles.title}>EduSign</Text>
            <Text style={styles.subtitle}>Sélectionnez un étudiant :</Text>
            <FlatList
                data={students}
                keyExtractor={(item) => item.id.toString()}
                renderItem={({ item }) => (
                    <TouchableOpacity
                        style={[
                            styles.studentItem,
                            selectedStudent?.id === item.id && styles.selectedStudent
                        ]}
                        onPress={() => setSelectedStudent(item)}
                    >
                        <Text style={styles.studentName}>
                            {item.first_name} {item.last_name}
                        </Text>
                    </TouchableOpacity>
                )}
            />
            <TouchableOpacity
                style={[styles.scanButton, !selectedStudent && styles.disabledButton]}
                onPress={() => selectedStudent && setShowScanner(true)}
                disabled={!selectedStudent}
            >
                <Text style={styles.scanButtonText}>Scanner un QR code</Text>
            </TouchableOpacity>
        </View>
    );
}

const styles = StyleSheet.create({
    mainContainer: {
        flex: 1,
        backgroundColor: '#fff',
        padding: 20,
    },
    title: {
        fontSize: 24,
        fontWeight: 'bold',
        textAlign: 'center',
        marginBottom: 20,
    },
    subtitle: {
        fontSize: 18,
        marginBottom: 10,
    },
    studentItem: {
        padding: 15,
        borderBottomWidth: 1,
        borderBottomColor: '#eee',
    },
    selectedStudent: {
        backgroundColor: '#e3f2fd',
    },
    studentName: {
        fontSize: 16,
    },
    scanButton: {
        backgroundColor: '#2196f3',
        padding: 15,
        borderRadius: 10,
        marginTop: 20,
        alignItems: 'center',
    },
    disabledButton: {
        backgroundColor: '#ccc',
    },
    scanButtonText: {
        color: 'white',
        fontSize: 16,
        fontWeight: '600',
    },
    container: {
        flex: 1,
        backgroundColor: 'black',
    },
    camera: {
        flex: 1,
    },
    overlay: {
        position: 'absolute',
        top: 0,
        left: 0,
        right: 0,
        bottom: 0,
        backgroundColor: 'rgba(0,0,0,0.5)',
        justifyContent: 'center',
        alignItems: 'center',
    },
    scanArea: {
        width: 250,
        height: 250,
        borderWidth: 2,
        borderColor: '#fff',
        backgroundColor: 'transparent',
    },
    buttonContainer: {
        position: 'absolute',
        bottom: 50,
        left: 0,
        right: 0,
        flexDirection: 'row',
        justifyContent: 'center',
        gap: 20,
    },
    button: {
        backgroundColor: '#fff',
        padding: 15,
        borderRadius: 10,
    },
    buttonText: {
        color: '#000',
        fontSize: 16,
        fontWeight: 'bold',
    },
});

export default Index;
